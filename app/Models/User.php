<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Task;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'contact',
        'state_id',
        'city_id',
        'address',
        'password',
    ];
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'email' => 'encrypted',
            'contact' => 'encrypted',
        ];
    }
    // app/Models/User.php

    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image
            ? asset('uploads/profile/' . $this->profile_image)
            : asset('default/profile.png'); // public/default/profile.png
    }
}
