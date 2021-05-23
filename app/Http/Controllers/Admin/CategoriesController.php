<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    public function index(Request $request) {
        
        $categories = Category::query()
                ->orderBy('priority')
                ->get();
        
        return view('admin.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function add(Request $request) {
        return view('admin.categories.add');
    }

    public function insert(Request $request) {

        $formData = $request->validate([
            'name' => ['required', 'string', 'min:2', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'min:10', 'max:255']
        ]);

        $categoryWithHighestPriority = Category::query()
                ->orderBy('priority', 'desc')
                ->first();
        $newCategory = new Category();
        
        if ($categoryWithHighestPriority) {
            $newCategory->priority = $categoryWithHighestPriority->priority + 1;
        } else {
            $newCategory->priority = 1;
        }
        $newCategory->fill($formData)->save();

        session()->flash('system_message', 'Category has been added!');
        return redirect()->route('admin.categories.index');
    }

    public function edit(Request $request, Category $category) {
        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category) {
        
        $formData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:20',
                Rule::unique('categories')->ignore($category->id)
            ],
            'description' => ['required', 'string', 'min:20', 'max:255']
        ]);

        $category->fill($formData)->save();
        
        session()->flash('system_message', 'Category has been edited!');
        return redirect()->route('admin.categories.index');
    }

    public function delete(Request $request) {

        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:categories,id']
        ]);

        $category = Category::findOrFail($formData['id']);
        
        if ($category->containBlogs()) {
            $category->setUnctegorizedBlogs();     
        }
        
        $category->delete();

        Category::query()
                ->where('priority', '>', $category->priority)
                ->decrement('priority');

        session()->flash('system_message', 'Category has been deleted!');
        return redirect()->route('admin.categories.index');
    }

    public function changePriorities(Request $request) {
        $formData = $request->validate([
            'priorities' => ['required', 'string']
        ]);

        $priorities = explode(',', $formData['priorities']);

        foreach ($priorities as $key => $id) {
            $category = Category::findOrFail($id);
            $category->priority = $key + 1;
            $category->save();
        }

        session()->flash('system_message', 'Categories have been ordered!');
        return redirect()->route('admin.categories.index');
    }
}
