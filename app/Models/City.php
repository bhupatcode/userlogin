<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['state_id', 'cname'];

    public function state()
{
    return $this->belongsTo(State::class);
}

public function users()
{
    return $this->hasMany(User::class);
}

}
