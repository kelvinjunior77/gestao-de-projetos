<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTarefaRequest extends FormRequest
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
            'status' => 'required|in:pendente,em_progresso,concluida',
            'prazo' => 'nullable|date',
            'projeto_id' => 'required|exists:projetos,id',
            'usuarios' => 'nullable|array',
            //'usuarios.*' => 'exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.string' => 'O título deve ser uma string.',
            'titulo.max' => 'O título não pode exceder 255 caracteres.',
            'descricao.string' => 'A descrição deve ser uma string.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status selecionado é inválido.',
            'prazo.date' => 'O prazo deve ser uma data válida.',
            'projeto_id.required' => 'O projeto é obrigatório.',
            'projeto_id.exists' => 'O projeto selecionado é inválido.',
            'usuarios.array' => 'Os usuários devem ser um array.',
            //'usuarios.*.exists' => 'Um dos usuários selecionados é inválido.',
        ];
    }
}
