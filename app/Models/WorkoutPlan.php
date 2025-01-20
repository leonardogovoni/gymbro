<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorkoutPlan extends Model
{
	use HasFactory;

	// Nome della tabella
	protected $table = 'workout_plans';

	// Gestisce l'abilitazione dei campi created_at e updated_at
	public $timestamps = true;

	// Aggiungi i campi che possono essere popolati in massa
	protected $fillable = [
		'user_id', 'title', 'description', 'enabled'
	];

	// Se l'ID non è 'id', specifica il nome della colonna dell'ID (opzionale)
	// protected $primaryKey = 'nome_colonna_id';

	public function user(): BelongsTo
	{
	    return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function exercises(): BelongsToMany
	{
		return $this->belongsToMany(Exercise::class, 'workout_plan_exercises', 'workout_plan_id', 'exercise_id')
			->withPivot('id', 'day', 'order', 'sets', 'reps', 'rest');
	}
}
