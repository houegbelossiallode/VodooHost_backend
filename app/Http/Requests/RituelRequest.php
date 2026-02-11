<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RituelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return [
            'titre'       => ['required','string','max:255'],
            'description' => ['required','string'],
            'symbole'     => ['file','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'duree'        => ['required','integer','min:1','max:10080'], // 1 min à 7 jours
            'precautions'  => ['required','string'],
        ];
    }


    public function messages(): array
    {
        return [
            'titre.required'       => 'Le titre est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'symbole.required'     => 'Le symbole est obligatoire.',
            'symbole.image'        => 'Le fichier doit être une image.',
            'symbole.mimes'        => 'Le symbole doit être au format jpg, jpeg, png ou webp.',
            'symbole.max'          => 'Le symbole ne doit pas dépasser 4 Mo.',
            'duree.required'       => 'La durée est obligatoire.',
            'duree.integer'        => 'La durée doit être un nombre entier.',
            'duree.min'            => 'La durée doit être au moins de 1 minute.',
            'duree.max'            => 'La durée ne peut pas dépasser 7 jours.',
            'precautions.required' => 'Les précautions sont obligatoires.',
        ];
    }


}
