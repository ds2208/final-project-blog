<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Ad;

class IndexController extends Controller {

    public function index() {
        
        $ads = Ad::query()
                ->where('index', '=', 1)
                ->orderBy('priority')
                ->get();

        $blogs = Blog::query()
                ->where('status', '=', 1)
                ->where('important', '=', 1)
                ->withCount('comments')
                ->orderBy('created_at', 'DESC')
                ->limit(3)
                ->get();

        for ($i = 0; $i < 4; $i++) {
            $latestBlogs[$i] = Blog::query()
                    ->where('status', '=', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit(3)
                    ->offset($i * 3)
                    ->get();
        }

        return view('front.index.index', [
            'ads' => $ads,
            'blogs' => $blogs,
            'latestBlogs' => $latestBlogs
        ]);
    }

}
