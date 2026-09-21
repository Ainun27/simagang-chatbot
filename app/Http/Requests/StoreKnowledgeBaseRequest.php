<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKnowledgeBaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category'  => 'nullable|string|max:100',
            'question'  => 'required|string|max:500',
            'answer'    => 'required|string',
            'is_active' => 'sometimes|boolean',
            'priority'  => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'question.required' => 'Pertanyaan wajib diisi.',
            'question.max'      => 'Pertanyaan maksimal 500 karakter.',
            'answer.required'   => 'Jawaban wajib diisi.',
            'priority.integer'  => 'Prioritas harus berupa bilangan bulat.',
        ];
    }
}
