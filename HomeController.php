<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public $categories;

     public function index()
    {
        $posts = Post::all();
        $categories = Category::all();
        return view('home', compact('posts', 'categories'));
    }

    public function adminview() {
        $posts = Post::all();
        $categories = Category::all();
        return view('layouts/adminview', compact('posts', 'categories'));
    }

 //   public function getCategoryPost() {
 //    $post = Post::find(3);
 //       foreach($post->categories()->get() as $category) {
 //           echo "Category ID:" . $category->id . "" . $category->name. "<br/>" ;
 //       }
 //       return "get all subjects id 9";
 //   }

    public function ajaxGetCategory(Request $request) {
        $posts = Category::find($request->get('category_id'))->posts()->get();

        $view = view('ajax',compact('posts'))->render();
        return response()->json(['html'=>$view]);
    }

    public function adminhome() {
        return view('layouts.adminhome');
    }

    public function addpost() {
        return view('layouts.add');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $categories = Category::all();
        $posts = new Post([
            'title' => $request->get('title'),
            'content' => $request->get('content')
        ]);
        $posts->save();
        return redirect('/adminhome')->with('success', 'Stock has been added');
    }
}
