<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'ssn',
        'email',
        'gender',
        'date_of_birth',
        'is_admin',
        'is_gym',
        'controlled_by',
        'password',
    ];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function workout_plans(): HasMany
    {
        // Secondo parametro: nome chiave nella classe workout (relazione n)
        // Terzo parametro: nome chiave nella classe user (relazione 1)
        return $this->hasMany(WorkoutPlan::class, 'user_id', 'id');
    }

    public function exercises_data(): HasMany
    {
        return $this->hasMany(ExerciseData::class, 'user_id', 'id');
    }

    public function gym_clients(): HasMany
    {
        return $this->hasMany(User::class, 'controlled_by', 'id');
    }
}
