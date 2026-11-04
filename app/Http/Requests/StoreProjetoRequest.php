<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjetoRequest extends FormRequest
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
            'nome' => 'required|string|max:255|unique:projetos,nome',
            'descricao' => 'nullable|string|max:1000',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'status' => 'required|in:pendente,em_andamento,concluido',
            //'responsavel_id' => 'required|exists:users,id',
            'prioridade' => 'nullable|in:baixa,média,alta',
            'visibilidade' => 'nullable|in:publico,privado',
            'github_link' => 'nullable|url|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do projeto é obrigatório.',
            'nome.unique' => 'Já existe um projeto com este nome.',
            'data_fim.after_or_equal' => 'A data de término deve ser igual ou posterior à data de início.',
            'status.required' => 'O status do projeto é obrigatório.',
            'responsavel_id.required' => 'O responsável pelo projeto é obrigatório.',
            //'responsavel_id.exists' => 'O responsável selecionado não existe.',
            'descricao.max' => 'A descrição não pode exceder 1000 caracteres.',
            'nome.max' => 'O nome do projeto não pode exceder 255 caracteres.',
            'data_inicio.date' => 'A data de início deve ser uma data válida.',
            'data_fim.date' => 'A data de término deve ser uma data válida.',
            //'status.in' => 'O status deve ser um dos seguintes: planejado, em andamento, concluído, atrasado.',
            'prioridade.in' => 'A prioridade deve ser baixa, média ou alta.',
            'visibilidade.in' => 'A visibilidade deve ser público ou privado.',
            'github_link.url' => 'O link do GitHub deve ser uma URL válida.',
            'github_link.max' => 'O link do GitHub não pode exceder 255 caracteres.',
        ];

    }

}