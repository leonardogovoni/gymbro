<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorkoutPlan extends Model
{
	use HasFactory;

	// Aggiungi qualsiasi altra configurazione, come la tabella specifica, se necessario
	protected $table = 'workout_plans';

	// Disabilita automaticamente l'uso dei campi created_at e updated_at
	public $timestamps = false;

	// Aggiungi i campi che possono essere popolati in massa
	protected $fillable = [
		'user_id', 'title', 'description', 'start', 'end', 'enabled',
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
			->withPivot('day', 'sequence', 'series', 'repetitions', 'rest');
	}
}
