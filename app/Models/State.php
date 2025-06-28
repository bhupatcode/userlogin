<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['sname'];

        public function cities()
{
    return $this->hasMany(City::class);
}

public function users()
{
    return $this->hasMany(User::class);
}

}
