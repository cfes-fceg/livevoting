<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EngSoc
 * @package App\Models
 */
class EngSoc extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'eng_socs';

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
                  'name',
                  'location',
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

    /**
     * Get the post that owns the comment.
     */
    public function voter()
    {
        return $this->belongsTo(User::class, 'voter_id');
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

}
