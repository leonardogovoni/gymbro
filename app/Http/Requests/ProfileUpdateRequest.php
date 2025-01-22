<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $today = Carbon::today()->toDateString(); // Data odierna in formato Y-m-d
        $minDate = Carbon::now()->subYears(130)->toDateString(); // Data di 130 anni fa

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:M,F,N'], // M = Uomo, F = Donna, N = Non specificato
            'date_of_birth' => 'required|date|before_or_equal:' . $today . '|after_or_equal:' . $minDate,
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }

    public function messages()
    {
        return [
            'date_of_birth.before_or_equal' => 'La data di nascita non può essere successiva alla data di oggi.',
        ];
    }
}
