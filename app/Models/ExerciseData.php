<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExerciseData extends Model
{
    use HasFactory;

	// Nome della tabella nel database
    protected $table = 'exercises_data';

    // Campi assegnabili in massa
    protected $fillable = [
        'user_id',
        'exercise_id',
        'workout_plan_pivot_id',
        'set',
        'reps',
        'used_weights'
    ];

    // Se necessario, definisci le relazioni
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}