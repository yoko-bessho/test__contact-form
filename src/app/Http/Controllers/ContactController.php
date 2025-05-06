<?php

namespace App\Http\Controllers;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;

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
        $contacts = Contact::with('category')->get();
        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));

    }
}