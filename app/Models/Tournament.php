<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    public function matches(){
        return $this-> hasMany(TennisMatch::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'classifications');
    }
}
