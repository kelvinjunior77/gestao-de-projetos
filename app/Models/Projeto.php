<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'slug',
        'github_link',
        'prioridade',
        'visibilidade',
        'user_id',
        'data_fim',
        'status',
    ];


    public function user()
    {
        // muitos para um (inverso)
        return $this->belongsTo(User::class);  
    }

    public function tarefas()
    {
        // um para muitos
        return $this->hasMany(Tarefa::class);
    }
}
