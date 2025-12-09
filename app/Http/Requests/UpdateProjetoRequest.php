<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjetoRequest extends FormRequest
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
            'nome' => 'required|string|max:255|unique:projetos,nome,' . $this->route('projeto')->id,
            'descricao' => 'nullable|string|max:1000',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'status' => 'required|in:pendente,em_andamento,concluido',
            //'responsavel_id' => 'required|exists:users,id',
            'prioridade' => 'nullable|in:baixa,média,alta',
            'visibilidade' => 'nullable|in:publico,privado',
            'github_link' => 'nullable|url|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.max' => 'O campo nome não pode ter mais de 255 caracteres.',
            'nome.unique' => 'O nome do projeto já está em uso.',
            'descricao.string' => 'O campo descrição deve ser uma string.',
            'descricao.max' => 'O campo descrição não pode ter mais de 1000 caracteres.',
            'data_fim.date' => 'O campo data de fim deve ser uma data válida.',
            'data_fim.after_or_equal' => 'A data de fim deve ser igual ou posterior à data de início.',
            'status.required' => 'O campo status é obrigatório.',
            'status.in' => 'O campo status deve ser um dos seguintes valores: pendente, em andamento, concluído.',
            'prioridade.in' => 'O campo prioridade deve ser um dos seguintes valores: baixa, média, alta.',
            'visibilidade.in' => 'O campo visibilidade deve ser um dos seguintes valores: público, privado.',
            'github_link.url' => 'O campo link do GitHub deve ser uma URL válida.',
            'github_link.max' => 'O campo link do GitHub não pode ter mais de 255 caracteres.',
        ];
    }
}