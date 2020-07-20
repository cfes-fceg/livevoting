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
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function voter()
    {
        return $this->belongsTo(User::class, 'voter_id');
    }

    public function engSoc()
    {
        return $this->belongsTo(EngSoc::class, 'eng_soc_id');
    }
}
