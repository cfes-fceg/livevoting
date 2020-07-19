<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public const OPTIONS = [
        "FOR",
        "AGAINST",
        "ABSTAIN"
    ];

    protected $fillable = ['vote'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function voter()
    {
        return $this->belongsTo(User::class);
    }

    public function engSoc()
    {
        return $this->belongsTo(EngSoc::class);
    }
}
