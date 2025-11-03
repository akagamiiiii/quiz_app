<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
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
            'question'    => ['required', 'string', 'max:1000'],
            'explanation' => ['required', 'string', 'max:1000'],
            'content1'    => ['required', 'string', 'max:255'],
            'content2'    => ['required', 'string', 'max:255'],
            'content3'    => ['required', 'string', 'max:255'],
            'content4'    => ['required', 'string', 'max:255'],
            'isCorrect1'  => ['required', 'integer', 'in:0,1'],
            'isCorrect2'  => ['required', 'integer', 'in:0,1'],
            'isCorrect3'  => ['required', 'integer', 'in:0,1'],
            'isCorrect4'  => ['required', 'integer', 'in:0,1'],
        ];
    }
}
