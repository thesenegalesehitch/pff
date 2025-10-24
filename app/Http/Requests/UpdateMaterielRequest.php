<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterielRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->profile->nom === 'ProprietaireMateriel';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'prixLocation' => 'required|numeric|min:0.01',
            'type_materiel_id' => 'required|exists:types_materiel,id',
            'status' => 'required|in:disponible,en maintenance',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom du matériel est obligatoire.',
            'prixLocation.required' => 'Le prix de location est obligatoire.',
            'prixLocation.numeric' => 'Le prix de location doit être un nombre.',
            'prixLocation.min' => 'Le prix de location doit être supérieur à 0.',
            'type_materiel_id.required' => 'Le type de matériel est obligatoire.',
            'type_materiel_id.exists' => 'Le type de matériel sélectionné n\'existe pas.',
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut doit être "disponible" ou "en maintenance".',
            'photo.image' => 'Le fichier doit être une image.',
            'photo.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou GIF.',
            'photo.max' => 'L\'image ne doit pas dépasser 2 Mo.',
        ];
    }
}
