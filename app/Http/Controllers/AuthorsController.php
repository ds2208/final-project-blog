<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;

class AuthorsController extends Controller {

    public function index(Request $request, User $author, $seoSlug) {
        
        if ($seoSlug != \Str::slug($author->name)) {
            return redirect()->away($author->getFrontUrl());
        }
        
        $blogs = Blog::query()
                ->where('status', '=', 1)
                ->where('author_id', '=', $author->id)
                ->withCount('comments')
                ->with('author', 'category', 'tags')
                ->paginate();

        return view('front.authors.index', [
            'author' => $author,
            'blogs' => $blogs
        ]);
    }

}
