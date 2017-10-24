<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'index']]);
    }

    public function index(){
        $title = 'Welcome To Laravel';
        return view('pages.index', compact('title'));
    }

    public function about(){
        return view('pages.about');
    }

    public function services(){
        $data = array(
            'title' => 'Services',
            'services' => ['Web Design', 'Programming', 'SEO']
        );
        return view('pages.services')->with($data);
    }

    public function dashboard(){
        return view('home');
    }
}
