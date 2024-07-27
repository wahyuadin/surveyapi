<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class survey extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public static function showById($id) {
        return Survey::with('questions')->where('id', $id)->latest()->get();
    }

    public static function getAll() {
        return Survey::with('questions')->get();
    }
}
