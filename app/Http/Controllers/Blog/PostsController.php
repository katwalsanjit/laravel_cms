<?php

namespace App\Http\Controllers\Blog;

use App\models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    public function show(Post $post)
    {

        return view('frontend.blog.show')->with('post', $post);
    }
}
