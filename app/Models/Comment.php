<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    //ATTR
    protected $table = 'comments';
    protected $fillable = ['name', 'email', 'content', 'blog_id'];
    
    //RELATIONSHIP
    public function blog() {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }
    
    //OTHER
    public function datePresenter() {
        return date('F Y', strtotime($this->created_at));
    }
}
