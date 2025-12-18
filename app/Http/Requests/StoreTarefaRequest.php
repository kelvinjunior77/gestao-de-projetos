<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTarefaRequest extends FormRequest
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
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'funcao' => 'nullable|string',
            'status' => 'required|in:pendente,em_andamento,concluida',
            'prioridade' => 'required|in:baixa,media,alta',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.string' => 'O título deve ser uma string.',
            'titulo.max' => 'O título não pode exceder 255 caracteres.',
            'descricao.string' => 'A descrição deve ser uma string.',
            'funcao.string' => 'A função deve ser uma string.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser um dos seguintes: pendente, em_andamento, concluida.',
            'prioridade.required' => 'A prioridade é obrigatória.',
            'prioridade.in' => 'A prioridade deve ser um dos seguintes: baixa, media, alta.',
            'data_fim.date' => 'A data de fim deve ser uma data válida.',
            'data_fim.after_or_equal' => 'A data de fim deve ser igual ou posterior à data de início.',
        ];
    }
}
