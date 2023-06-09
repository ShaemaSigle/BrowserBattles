<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enemy extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function encounter(){
        return $this->hasMany(Encounter::class);
    }
}
