<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'data_inicio',
        'data_fim',
        'user_id',
    ];

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
}
