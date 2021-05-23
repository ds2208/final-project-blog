<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Comment;

class BlogsController extends Controller {

    public function index(Request $request) {

        $blogs = Blog::query()
                ->where('status', '=', 1)
                ->orderBy('created_at')
                ->withCount('comments')
                ->with(['category', 'author', 'tags'])
                ->paginate(12);

        return view('front.blogs.index', [
            'blogs' => $blogs
        ]);
    }

    public function singleBlog(Request $request, Blog $blog, string $seoSlug) {
        
        if($seoSlug != \Str::slug($blog->title)){
            return redirect()->away($blog->getFrontUrl());
        }
        
        if ($blog->status == 0) {
            session()->put('system_error', 'You can not see this blog!');
            return redirect()->route('front.index.index');
        }

        $blog->views++;
        $blog->save();
        
        return view('front.blogs.single', [
            'blog' => $blog
        ]);
    }

    public function commentContainer(Request $request) {
        
        $formData = $request->validate([
            'blog_id' => ['required', 'numeric', 'exists:blogs,id']
        ]);
        
        $blog = Blog::findOrFail($formData['blog_id']);
        
        $comments = $blog->comments()
                ->where('index', '=', 1)
                ->get();
        
        return view('front.blogs.partials.comments', [
            'blog' => $blog,
            'comments' => $comments
        ]);
    }

    public function addComment(Request $request) {
        
        $formData = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'content' => ['required', 'string', 'min:50', 'max:500'],
            'blog_id' => ['required', 'numeric', 'exists:blogs,id']
        ]);

        $newComment = new Comment();
        $newComment->fill($formData);
        $newComment->save();

        return response()->json([
                    'systemMessage' => 'Comment has been added!',
        ]);
    }

}
