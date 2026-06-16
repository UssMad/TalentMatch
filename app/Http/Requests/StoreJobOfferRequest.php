<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobOfferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'required_skills' => ['required', 'array', 'min:1'],
            'required_skills.*' => ['required', 'string'],
            'min_experience' => ['required', 'integer', 'min:0'],
        ];
    }
}
