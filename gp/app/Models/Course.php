<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Course extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'course';
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

    public function skills()
    {
        return $this->belongsToMany(Skill::class,'course_skill');
    }
}
