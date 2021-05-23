<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Tag;

class TagsController extends Controller {

    public function index(Request $request, Tag $tag, $seoSlug) {
        
        if ($seoSlug != \Str::slug($tag->name)) {
            return redirect()->away($tag->getFrontUrl());
        }
        
        $blogs = Blog::query()
                ->where('status', '=', 1)
                ->whereHas('tags', function ($subQuery) use ($tag) {
                    $subQuery->where('tag_id', '=', $tag->id);
                })
                ->withCount('comments')
                ->with('author', 'category', 'tags')
                ->paginate();

        return view('front.tags.index', [
            'tag' => $tag,
            'blogs' => $blogs
        ]);
    }

}
