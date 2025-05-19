<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\StreamedResponse;
use symforny\Component\HttpFoundation\Rsponse;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }


    public function confirm(ContactRequest $request)
    {
        $contact = $request->only([
            'last_name', 'first_name', 'email', 'gender','address','building','detail', 'category_id']);

        $contact['tel1'] = $request->input('tel1');
        $contact['tel2'] = $request->input('tel2');
        $contact['tel3'] = $request->input('tel3');
        $contact['tel'] = $contact['tel1'] . $contact['tel2'] . $contact['tel3'];

        $contact['category'] = Category::find($request->input('category_id'));

        return view('confirm', compact('contact'));
    }

    public function store(ContactRequest $request)
    {
        // dd($request->all());
        $contact = $request->only(['first_name','last_name', 'email', 'tel', 'gender','address','building','detail', 'category_id','content']);

        $contact['tel1'] = $request->input('tel1');
        $contact['tel2'] = $request->input('tel2');
        $contact['tel3'] = $request->input('tel3');
        $contact['tel'] = $contact['tel1'] . $contact['tel2'] . $contact['tel3'];

        $genderMap = ['男性' => 1, '女性' => 2, 'その他' => 3];
        $contact['gender'] = $genderMap[$contact['gender']];

        $contact['category'] = Category::find($request->input('category_id'));

        Contact::create($contact);

        return view('thanks');
    }


    public function thanks()
    {
        return view('thanks');
    }


    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function admin()
    {
        $contacts = Contact::with('category')->Paginate(7);
        $categories = Category::all();
        $csvData = Contact::all();

        return view('admin', compact('contacts', 'categories', 'csvData'));

    }

    public function destroy(Request $request)
    {
        Contact::find($request->id)->delete();
        return redirect('admin');
    }

    public function search(Request $request)
    {
        if ($request->has('reset')) {
            return redirect('admin')->withInput();
        }
        $query = Contact::query();
        $query = $this->getSearchQuery($request, $query);

        $contacts = $query->paginate(7);
        $csvData = $query->get();
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories', 'csvData'));
    }

    public function export(Request $request)
    {
        $query = Contact::query();
        $query = $this->getSearchQuery($request, $query);
        $csvData = $query->get()->toArray();
        $csvHeader = [
            'id',
            'category_id',
            'first_name',
            'last_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'detail',
            'created_at',
            'updated_at',
        ];
        $response = new StreamedResponse(function()use ($csvHeader, $csvData) {
            $createCsvFile = fopen('php://output', 'w');
            mb_convert_variables('SJIS-win', 'UTF-8', $csvHeader);
            fputcsv($createCsvFile, $csvHeader);
            foreach ($csvData as $csv) {
                $csv['created_at'] = Date::make($csv['created_at'])->setTimezone('Asia/tokyo')->format('Y/m/d H:i:s');
                $csv['updated_at'] = Date::make($csv['updated_at'])->setTimezone('Asia/tokyo')->format('Y/m/d H:i:s');
                fputcsv($createCsvFile, $csv);
            }
            fclose($createCsvFile);
        }, 200, [
            'Content-Type' => 'text_csv',
            'Content-Disposition' => 'attachment; filename="contacts.csv"',
        ]);
        return $response;
    }

    private function getSearchQuery($request, $query)
    {
        // dd($request->all());
        if(!empty($request->keyword)) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword. '%');

            });
        }
        if (!empty($request->gender)) {
            $query->where('gender', '=', $request->gender);
        }
        if (!empty($request->category_id)) {
            $query->where('category_id', '=', $request->category_id);
        }
        if (!empty($request->date)) {
            $query->whereDate('created_at', '=', $request->date);
        }

        return $query;
    }
};