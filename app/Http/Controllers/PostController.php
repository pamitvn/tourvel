<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
   public function __invoke(string $slug)
   {
      $post = Post::whereSlug($slug)->firstOrFail();

      return view('posts.detail', compact('post'));
   }
}
