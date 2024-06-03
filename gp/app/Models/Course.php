<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Course extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'course';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'price', 'detail'];

    public function tutors()
    {
        return $this->hasMany(Tutor::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
