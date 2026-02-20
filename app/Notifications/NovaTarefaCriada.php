<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NovaTarefaCriada extends Notification
{
    use Queueable;

    public $tarefa;

    /**
     * Recebe a tarefa criada
     */
    public function __construct($tarefa)
    {
        $this->tarefa = $tarefa;
    }

    /**
     * Canal de entrega
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Dados que serão salvos na tabela notifications
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'titulo' => $this->tarefa->titulo,
            'funcao' => $this->tarefa->funcao,
            'descricao' => $this->tarefa->descricao,
            'projeto_id' => $this->tarefa->projeto_id,
            'criador_nome' => Auth::user()->name,
            'user_id' => Auth::user()->id,
            'expires_at' => now()->addHours(24), // Expira em 24 horas
        ];
    }

    /**
     * Representação em array (opcional, mas mantemos igual)
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
