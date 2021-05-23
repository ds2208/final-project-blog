<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Blog extends Model {

    use HasFactory;

    //ATTR
    protected $table = 'blogs';
    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'description',
        'important',
        'status',
        'content'
    ];

    //RELATIONSHIP
    public function Category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function author() {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'blog_tags', 'blog_id', 'tag_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'blog_id', 'id');
    }

    //OTHER

    public function previousBlog() {

        $blog = Blog::query()
                ->orderBy('created_at', 'DESC')
                ->where('created_at', '<', $this->created_at)
                ->first();
        if ($blog == null) {
            return $this;
        }
        return $blog;
    }

    public function nextBlog() {
        $blog = Blog::query()
                ->orderBy('created_at', 'ASC')
                ->where('created_at', '>', $this->created_at)
                ->first();
        if ($blog == null) {
            return $this;
        }
        return $blog;
    }

    /**
     * 
     * @return boolean
     */
    public function haveCategory() {
        $categories = Category::query()->pluck('id')->toArray();
        foreach ($categories as $category) {
            if ($this->category_id == $category) {
                return true;
            }
        }
        return false;
    }

    public function getFrontUrl() {
        return route('front.blogs.single', [
            'blog' => $this->id,
            'seoSlug' => \Str::slug($this->title)
        ]);
    }

    /**
     * 
     * @return string
     */
    public function dateInAgoFormat() {
        $blogDate = strtotime($this->created_at);
        $currentDate = time();
        $diff = abs($currentDate - $blogDate);
        $day = 60 * 60 * 24;
        $oneMonth = $day * 30;
        $oneYear = $oneMonth * 12;

        $years = floor($diff / $oneYear);
        $months = floor(($diff - $years * $oneYear) / $oneMonth);
        $days = floor(($diff - $years * $oneYear - $months * $oneMonth ) / $day);

        if ($years > 0) {
            return $years . ' years ago';
        } elseif ($months > 0) {
            return $months . ' months ago';
        } else {
            return $days . ' days ago';
        }
    }

    /**
     * 
     * @return string
     */
    public function datePresenter() {
        return date('d F | Y', strtotime($this->created_at));
    }

    public function dateFooterPresenter() {
        return date('F d, Y', strtotime($this->created_at));
    }

    //photo

    /**
     * 
     * @return string
     */
    public function getPhotoUrl() {
        if ($this->photo) {
            return url('/storage/blogs/' . $this->photo);
        }
        return url('/themes/front/img/featured-pic-1.jpeg');
    }

    public function deletePhoto() {
        if (!$this->photo) {
            return $this;
        }
        $photoFilePath = public_path('/storage/blogs/' . $this->photo);
        $photoTumbPath = public_path('/storage/blogs/thumbs/' . $this->photo);
        if (!is_file($photoFilePath)) {
            return $this;
        }
        if (!is_file($photoTumbPath)) {
            return $this;
        }
        unlink($photoFilePath);
        unlink($photoTumbPath);
        return $this;
    }

    public function getPhotoThumbUrl() {
        if ($this->photo) {
            return url('/storage/blogs/thumbs/' . $this->photo);
        }
        return url('/themes/front/img/featured-pic-1.jpeg');
    }

}
