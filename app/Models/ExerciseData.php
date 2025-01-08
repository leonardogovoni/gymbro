<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseData extends Model
{
    use HasFactory;

    protected $table = 'exercises_data'; // Nome della tabella nel database

    // Campi assegnabili in massa
    protected $fillable = [
        'user_id',
        'exercise_id',
        'sets',
        'reps',
        'used_kg',
        'date',
    ];

    // Se necessario, definisci le relazioni
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}