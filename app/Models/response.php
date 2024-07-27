<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class response extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'answers' => 'array',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function question() {
        return $this->belongsTo(question::class);
    }

    public static function showById($id) {
        return self::with('question')->where('survey_id', $id)->latest()->get();
    }

}
