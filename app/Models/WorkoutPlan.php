<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

	protected function user(): BelongsTo
	{
	    return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
