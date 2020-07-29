<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Question extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'questions';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'is_active'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function votes()
    {
        return $this->hasMany(Vote::class, 'question_id');
    }

    public function results()
    {
        $results = $this->votes()->select('vote', DB::raw('count(*) as total'))->groupBy('vote')->get();
        $response = [];
        $total = 0;
        if (count($results) > 0)
            foreach ($results as $result) {
                $total += $result->total;
                $response[$result->vote] = $result->total;
            }
        else
            foreach (Vote::OPTIONS as $option) {
                $response[$option] = 0;
            }
        $response['TOTAL'] = $total;
        return $response;
    }


}
