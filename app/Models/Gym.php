<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'telephone',
        'user_id',
        'licenseType',
        'licensePayment',
        'licenseExpiration',
    ];

    protected $dates = ['licenseExpiration'];

    // Relazione: una palestra appartiene a un utente (il proprietario della palestra)
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relazione: una palestra ha molti utenti sotto di essa
    public function controlledUsers()
    {
        return $this->hasMany(User::class, 'controlled_by', 'user_id');
    }
}
