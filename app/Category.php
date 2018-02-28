<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name', 'timer_type',  'hour','minutes','seconds','pausable','status', 'answer_required', 'show_all_questions'];

    public function polls()
    {
        return $this->hasMany('App\Poll');
    }
}
