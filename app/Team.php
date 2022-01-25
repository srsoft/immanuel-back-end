<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Team extends Model
{
    protected $fillable = ['name', 'image', 'job_title', 'LinkedIn', 'facebook'];
    // protected $guarded = [];
}
