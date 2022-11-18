<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Photo;

class article extends Model
{
    public function getUser(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function getPhoto(){
        return $this->hasOne(Photo::class);
    }
    public function getPhotos(){
        return $this->hasMany(Photo::class);
    }
}