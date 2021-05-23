<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Validation\Rule;

class BlogsController extends Controller {

    public function index() {
        
        $authors = User::query()->orderBy('name')->get();
        $categories = Category::query()->orderBy('priority')->get();
        $tags = Tag::all();
        
        return view('admin.blogs.index', [
            'authors' => $authors,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function datatable(Request $request) {

        $searchFilters = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'author_id' => ['nullable', 'numeric', 'exists:users,id'],
            'category_id' => ['nullable', 'numeric', 'exists:categories,id'],
            'status' => ['nullable', 'numeric', 'in:0,1'],
            'important' => ['nullable', 'numeric', 'in:0,1'],
            'tags' => ['nullable', 'array', 'exists:tags,id'],
        ]);

        $query = Blog::query()
                ->with(['author', 'category', 'comments'])
                ->join('users', 'blogs.author_id', '=', 'users.id')
                ->leftJoin('categories', 'blogs.category_id', '=', 'categories.id')
                ->leftJoin('comments', 'blogs.id', '=', 'comments.blog_id')
                ->select([
                    'blogs.*',
                    'users.name AS author_name',
                    'categories.name AS category_name',
                    \DB::raw('count(comments.id) as total_comments')
                ])
                ->groupBy('blogs.id');

        $dataTable = \DataTables::of($query);
        $dataTable->addColumn('tags', function ($blog) {
            return optional($blog->tags->pluck('name'))->join(', ');
        })->addColumn('actions', function ($blog) {
            return view('admin.blogs.partials.actions', ['blog' => $blog]);
        })->editColumn('title', function ($blog) {
            return '<strong>' . $blog->title . '</strong>';
        })->editColumn('photo', function ($blog) {
            return view('admin.blogs.partials.blog_photo', ['blog' => $blog]);
        })->editColumn('status', function ($blog) {
            return view('admin.blogs.partials.status', ['blog' => $blog]);
        })->editColumn('important', function ($blog) {
            return view('admin.blogs.partials.important', ['blog' => $blog]);
        })->editColumn('created_at', function ($blog) {
            return $blog->datePresenter();
        });
        $dataTable->rawColumns(['title', 'photo', 'actions']);

        $dataTable->filter(function ($query) use ($request, $searchFilters) {
            if (
                    $request->has('search') &&
                    is_array($request->get('search')) &&
                    isset($request->get('search')['value'])
            ) {
                $searchTerm = $request->get('search')['value'];

                $query->where(function ($query) use ($searchTerm) {
                    $query->orWhere('blogs.title', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('blogs.description', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('blogs.content', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('users.name', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('categories.name', 'LIKE', '%' . $searchTerm . '%');
                });
            }

            if (isset($searchFilters['title'])) {
                $query->where('blogs.title', 'LIKE', '%' . $searchFilters['title'] . '%');
            }

            if (isset($searchFilters['author_id'])) {
                $query->where('blogs.author_id', 'LIKE', '%' . $searchFilters['author_id'] . '%');
            }

            if (isset($searchFilters['category_id'])) {
                $query->where('blogs.category_id', 'LIKE', '%' . $searchFilters['category_id'] . '%');
            }

            if (isset($searchFilters['status'])) {
                $query->where('blogs.status', 'LIKE', '%' . $searchFilters['status'] . '%');
            }

            if (isset($searchFilters['important'])) {
                $query->where('blogs.important', 'LIKE', '%' . $searchFilters['important'] . '%');
            }

            if (isset($searchFilters['tags'])) {
                $query->whereHas('tags', function ($subQuery) use ($searchFilters) {
                    $subQuery->whereIn('tag_id', $searchFilters['tags']);
                });
            }
        });
        return $dataTable->make(true);
    }

    public function add(Request $request) {
        
        $authors = User::query()->orderBy('name')->get();
        $categories = Category::query()->orderBy('priority')->get();
        $tags = Tag::all();
        
        return view('admin.blogs.add', [
            'authors' => $authors,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function insert(Request $request) {
        
        $formData = $request->validate([
            'author_id' => ['required', 'numeric', 'exists:users,id'],
            'category_id' => ['nullable', 'numeric', 'exists:categories,id'],
            'title' => ['required', 'string', 'min:20', 'max:255', 'unique:blogs,title'],
            'description' => ['required', 'string', 'min:50', 'max:500'],
            'status' => ['required', 'numeric', 'in:0,1'],
            'important' => ['required', 'numeric', 'in:0,1'],
            'tag_id' => ['required', 'array', 'exists:tags,id', 'min:2'],
            'photo' => ['nullable', 'file', 'image'],
            'content' => ['nullable', 'string']
        ]);

        $newBlog = new Blog();
        $newBlog->fill($formData);
        $newBlog->save();
        $newBlog->tags()->sync($formData['tag_id']);
        $this->handlePhotoUpload($request, $newBlog);

        session()->flash('system_message', __('New Blog has been saved!'));
        return redirect()->route('admin.blogs.index');
    }

    public function edit(Request $request, Blog $blog) {
        
        $authors = User::query()->orderBy('name')->get();
        $categories = Category::query()->orderBy('priority')->get();
        $tags = Tag::all();
        
        return view('admin.blogs.edit', [
            'blog' => $blog,
            'authors' => $authors,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function update(Request $request, Blog $blog) {
        
        $formData = $request->validate([
            'author_id' => ['required', ['numeric', 'exists:user,id']],
            'category_id' => ['required', ['numeric', 'exists:categories,id']],
            'title' => ['required', 'string', 'min:20', 'max:255', Rule::unique('blogs')->ignore($blog->id)],
            'description' => ['nullable', 'string', 'min:50', 'max:500'],
            'status' => ['required', 'numeric', 'in:0,1'],
            'important' => ['required', 'numeric', 'in:0,1'],
            'tag_id' => ['required', 'array', 'exists:tags,id', 'min:2'],
            'photo' => ['nullable', 'file', 'image'],
            'content' => ['nullable', 'string']
        ]);

        $blog->fill($formData);
        $blog->tags()->sync($formData['tag_id']);
        $this->handlePhotoUpload($request, $blog);
        $blog->save();

        session()->flash('system_message', __('Blog has been changed!'));
        return redirect()->route('admin.blogs.index');
    }

    public function delete(Request $request) {
        
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blogs,id']
        ]);
        
        $blog = Blog::findOrFail($formData['id']);
        $blog->delete();
        \DB::table('blog_tags')
                ->where('blog_id', '=', $blog->id)
                ->delete();
        $blog->deletePhoto();

        return response()->json([
                    'system_message' => __('Blog has been deleted!')
        ]);
    }

    public function getImportant(Request $request) {
        
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blogs,id'],
        ]);
        
        $blog = Blog::findOrFail($formData['id']);
        $blog->important = 1;
        $blog->save();

        return response()->json([
                    'system_message' => __('Blog has been changed in important!')
        ]);
    }

    public function getNotImportant(Request $request) {
        
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blogs,id'],
        ]);
        
        $blog = Blog::findOrFail($formData['id']);
        $blog->important = 0;
        $blog->save();

        return response()->json([
                    'system_message' => __('Blog has been changed in not important!')
        ]);
    }

    public function disable(Request $request) {
        
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blogs,id'],
        ]);
        
        $blog = Blog::findOrFail($formData['id']);
        $blog->status = 0;
        $blog->save();

        return response()->json([
                    'system_message' => __('Blog has been disabled')
        ]);
    }

    public function enable(Request $request) {
        
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blogs,id'],
        ]);
        
        $blog = Blog::findOrFail($formData['id']);
        $blog->status = 1;
        $blog->save();

        return response()->json([
                    'system_message' => __('Blog has been enabled')
        ]);
    }

    protected function handlePhotoUpload(Request $request, Blog $blog) {
        
        if ($request->hasFile('photo')) {
            $blog->deletePhoto();
            $file = $request->file('photo');
            $fileName = $blog->id . '_photo_' . $file->getClientOriginalName();
            $file->move(public_path('/storage/blogs/'), $fileName);
            $blog->photo = $fileName;
            $blog->save();

            \Image::make(public_path('/storage/blogs/' . $blog->photo))
                    ->fit(800, 600)
                    ->save();
            \Image::make(public_path('/storage/blogs/' . $blog->photo))
                    ->fit(256, 256)
                    ->save(public_path('/storage/blogs/thumbs/' . $blog->photo));
        }
    }

    public function deletePhoto(Request $request, Blog $blog) {

        $blog->deletePhoto();
        $blog->photo = null;
        $blog->save();

        return response()->json([
                    'system_message' => 'Photo has been deleted!',
                    'photo_url' => $blog->getPhotoUrl()
        ]);
    }

}
