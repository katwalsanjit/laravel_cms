<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\models\Category;
use App\models\Post;
use App\models\Tag;
use Illuminate\Http\Request;
use kcfinder\session;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }

    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')
            ->with('categories', Category::all())
            ->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        //dd($request->all());
        //dd($request->image->store('posts'));
        //upload the image
        $image = $request->image->store('posts');
        //create the post

        $post = Post::create([
            'title'         =>$request->title,
            'description'   =>$request->description,
            'post_content'  =>$request->post_content,
            'published_at'  =>$request->published_at,
            'image'         =>$image,
            'category_id'   =>$request->category,
            'user_id'       =>auth()->user()->id,
        ]);

        if ($request->tags){
            $post->tags()->attach($request->tags);
        }

        session()->flash('success', 'Post Created Successfully');

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)
            ->with('categories', Category::all())
            ->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only(['title', 'description', 'published_at', 'post_content']);
        //check if new image
        if ($request->hasFile('image')){
            //update the image
            $image = $request->image->store('posts');

            //delete old one
            $post->deleteImage();

            $data['image'] = $image;
        }
        if ($request->tags){
            $post->tags()->sync($request->tags);
        }


        //update attribute, flash message and redirect to index page
        $post->update($data);
        session()->flash('success', 'Post Updated successfully');
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        if ($post->trashed()){
            $post->deleteImage();
            $post->forceDelete();
        }else{
            $post->delete();
        }
        session()->flash('success', 'Post deleted successfully');

        return redirect(route('posts.index'));
    }

    //Display a list of all trashed posts

    public function trashed()
    {
        $trashed = Post::onlyTrashed()->get();

        return view('posts.index')->with('posts', $trashed); //with('posts', $trashed)
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        $post->restore();

        session()->flash('success', 'Post restored successfully');

        return redirect()->back();
    }
}
