<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {

    use HasFactory,
        Notifiable;

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //RELATIONSHIP
    public function blogs() {
        return $this->hasMany(Blog::class, 'author_id', 'id');
    }

    //OTHER
    public function isEnabled() {
        return $this->status == self::STATUS_ENABLED;
    }

    public function isDisabled() {
        return $this->status == self::STATUS_DISABLED;
    }

    public function getFrontUrl() {
        return route('front.authors.index', [
            'author' => $this->id,
            'seoSlug' => \Str::slug($this->name)
        ]);
    }

    public function getPhotoUrl() {
        if ($this->photo) {
            return url('/storage/users/' . $this->photo);
        }
        return url('/themes/front/img/avatar-2.jpg');
    }

    public function deletePhoto() {
        if (!$this->photo) {
            return $this;
        }

        $photoPath = public_path('/storage/users/' . $this->photo);

        if (is_file($photoPath)) {
            unlink($photoPath);
        }
        return $this;
    }

}
