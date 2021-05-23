<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model {

    use HasFactory;

    //ATTR
    protected $table = 'ads';
    protected $fillable = [
        'title',
        'button_title',
        'url'
    ];

    //OTHERS
    public function getPhotoUrl() {
        if ($this->photo) {
            return url('/storage/ads/' . $this->photo);
        }
        return '/themes/front/img/featured-pic-3.jpeg';
    }

    public function deletePhoto() {
        if (!$this->photo) {
            return $this;
        }

        $photoPath = public_path('/storage/ads/' . $this->photo);

        if (is_file($photoPath)) {
            unlink($photoPath);
        }
        return $this;
    }

     public function changeIndex() {
        if ($this->index == 0) {
            $this->index = 1;
            return $this;
        }
        $this->index = 0;
        return $this;
    }
    
    public function isOnIndexPage(){
        if($this->index == 1){
            return true;
        }
        return false;
    }
}
