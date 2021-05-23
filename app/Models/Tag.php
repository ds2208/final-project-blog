<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    use HasFactory;

    //ATTR
    protected $table = 'tags';
    protected $fillable = ['name'];

    //RELATIONSHIP
    public function blogs() {
        return $this->belongsToMany(
                        Blog::class,
                        'blog_tags',
                        'tag_id',
                        'blog_id'
        );
    }

    //OTHERS
    public function getFrontUrl() {
        return route('front.tags.index', [
            'tag' => $this->id,
            'seoSlug' => \Str::slug($this->name)
        ]);
    }

}
