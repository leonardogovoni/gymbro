<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Gym;
use App\Models\User;

class CheckGymLicense
{
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Middleware CheckGymLicense eseguito per l\'utente: ' . Auth::id());

        $user = Auth::user();

        if (!$user) {
            return $next($request); // Se l'utente non è autenticato, non blocchiamo l'accesso
        }

        // Trova la palestra associata all'utente principale
        $gym = Gym::where('user_id', $user->id)->first();

        if (!$gym) {
            // Se l'utente non è proprietario di una palestra, controlliamo se è sotto un altro utente
            $gym = Gym::where('user_id', $user->controlled_by)->first();
        }

        if ($gym && $gym->licenseExpiration < now()->toDateString()) {
            Log::warning("Accesso bloccato per l'utente {$user->id} a causa della licenza scaduta.");
            abort(403, 'Rinnovare l\'abbonamento all\'app Gymbro');
        }

        return $next($request);
    }
}
