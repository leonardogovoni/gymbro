<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
	/**
	 * Display the registration view.
	 */
	public function create(): View
	{
		return view('auth.register');
	}

	/**
	 * Handle an incoming registration request.
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			'name' => ['required', 'string', 'max:255'],
			'surname' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
			'gender' => ['required', 'string', 'uppercase', 'max:1'],
			'date_of_birth' => 'required|date|before_or_equal:' . Carbon::today()->toDateString(),
			'password' => ['required', 'confirmed', Rules\Password::defaults()],
		]);

		$user = User::create([
			'first_name' => $request->name,
			'last_name' => $request->surname,
			'email' => $request->email,
			'gender' => $request->gender,
			'date_of_birth' => $request->date_of_birth,
			'password' => Hash::make($request->password),
		]);

		event(new Registered($user));

		Auth::login($user);

		return redirect(route('training', absolute: false));
	}

	public function messages()
	{
		return [
			'date_of_birth.before_or_equal' => 'La data di nascita non può essere successiva alla data di oggi.',
			'date_of_birth.after_or_equal' => 'La data di nascita non può essere inferiore a 130 anni fa.',
		];
	}
}
