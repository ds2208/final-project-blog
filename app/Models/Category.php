<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    use HasFactory;

    //ATTR
    protected $table = 'categories';
    protected $fillable = ['name', 'description'];

    //RELATIONSHIP
    public function blogs() {
        return $this->hasMany(Blog::class, 'category_id', 'id');
    }

    //OTHER

    /**
     * 
     * @return boolean
     */
    public function containBlogs() {
        foreach ($this->blogs as $blog) {
            if ($blog->category_id == $this->id) {
                return true;
            }
        }
        return false;
    }

    public function setUnctegorizedBlogs() {
        foreach ($this->blogs as $blog) {
            $blog->category_id = null;
            $blog->save();
        }
    }

    public function getFrontUrl() {
        return route('front.categories.index', [
            'category' => $this->id,
            'seoSlug' => \Str::slug($this->name)
        ]);
    }

}
