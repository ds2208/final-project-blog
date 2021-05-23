<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Blog;

class CategoriesController extends Controller {

    public function index(Request $request, Category $category, $seoSlug) {
        
        if ($seoSlug != \Str::slug($category->name)) {
            return redirect()->away($category->getFrontUrl());
        }

        $blogs = Blog::query()
                ->where('status', '=', 1)
                ->where('category_id', '=', $category->id)
                ->withCount('comments')
                ->with('author', 'category', 'tags')
                ->paginate();

        return view('front.categories.index', [
            'category' => $category,
            'blogs' => $blogs
        ]);
    }

}
