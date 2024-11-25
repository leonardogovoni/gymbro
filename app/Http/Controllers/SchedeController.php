<?php

namespace App\Http\Controllers;

use App\Models\Scheda;
use Illuminate\Http\Request;

class SchedeController extends Controller
{
	// Metodo per visualizzare la pagina e recuperare le schede
	public function index()
	{
		// Recupera tutte le schede dal database
		$schede = Scheda::all();

		// Passa i dati alla vista
		return view('schede', compact('schede'));
    }

	// Metodo per gestire i dati inviati dal form
	public function store(Request $request)
	{
		// Validazione dei dati
		$validatedData = $request->validate([
			'data1' => 'required|string|max:255',
			'data2' => 'required|string|max:255',
			'data3' => 'required|date',
			'data4' => 'required|date',
		]);

		// Inserimento dei dati nel database
        Scheda::create([
			// L'utente e' sempre loggato, quindi l'ID deve esistere
			'id_utente' => auth()->id(),

			// Valori inseriti nel form
			'titolo' => $validatedData['data1'],
			'descrizione' => $validatedData['data2'],
			'inizio' => $validatedData['data3'],
			'fine' => $validatedData['data4'],

			// default: false
			'abilitata' => false
		]);

		return redirect()->route('schede');
	}
}
