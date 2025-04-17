<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Symfony\Component\Mime\Encoder\ContentEncoderInterface;

class ContactController extends Controller
{
    public function index()
    {
        $contents = Contact::with('category')->get();
        $categories = Category::all();

        return view('index', compact('categories'));
    }


    public function confirm(Request $request)
    {
        $tel = $request->input('tel1').$request->input('tel2').$request->input('tel3');
        $contact = $request->only(['first_name','last_name', 'email', 'tel', 'gender','address','building','detail', 'category_id','content']);
        $contact['tel'] = $tel;
        $contact['category'] = Category::find($request->input('category_id'));

        return view('confirm', compact('contact'));
    }

    public function store(Request $request)
    {
        $tel = $request->input('tel1').$request->input('tel2').$request->input('tel3');
        $contact = $request->only(['first_name','last_name', 'email', 'tel', 'gender','address','building','detail', 'category_id','content']);
        $contact['tel'] = $tel;
        $contact['category'] = Category::find($request->input('category_id'));

        $contact = Contact::create($contact);
        
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

    public function admin(){
        return view('admin');
    }



}
