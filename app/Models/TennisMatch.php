<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TennisMatch extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsToMany(User::class, 'results');
    }

    public function tournaments(){
        return $this-> belongsTo(Tournament::class);
    }
}
