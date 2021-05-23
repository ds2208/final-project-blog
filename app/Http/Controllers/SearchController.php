<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Validation\Rule;

class SearchController extends Controller {

    public function index(Request $request) {

        $param = $request->validate([
            'search' => ['nullable', 'string', 'min:2', 'max:255']
        ]);

        $query = Blog::query();

        if (!empty($param['search'])) {

            $searchTerm = $param['search'];

            $query->where(function ($query) use ($searchTerm) {
                $query->orWhere('blogs.title', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('blogs.description', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('blogs.content', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $blogs = $query->where('status', '=', 1)
                ->withCount('comments')
                ->with('author', 'category', 'tags')
                ->paginate()
                ->appends($param);

        return view('front.search.index', [
            'search' => $param['search'],
            'blogs' => $blogs
        ]);
    }

}
