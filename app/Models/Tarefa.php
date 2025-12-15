<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tarefa extends Model
{
    protected $fillable = [
        'titulo',
        'slug',
        'descricao',
        'status',
        'funcao',
        'prioridade',
        'data_fim',
        'user_id',
        'projeto_id',
        //'atribuida_para',
    ];

    // autor da tarefa
    public function user()
    {
        // muitos para um (inverso)
        return $this->belongsTo(User::class);
        
    }

    public function projeto()
    {
        // muitos para um (inverso)
        return $this->belongsTo(Projeto::class);
    }

    // Usuários atribuídos à tarefa (devs, colaboradores)
    public function responsaveis(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tarefa_user')
            ->withTimestamps();
    }
}
