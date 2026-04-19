<?php

namespace App\Controller;

use App\Model\Reserva;
use Exception;

class ReservaController
{
    private function getBearerToken()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $matches = [];
            if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
                return $matches[1];
            }
        }
        throw new Exception('Token não fornecido ou inválido');
    }

    function selectAll()
    {
        $token = $this->getBearerToken();
        $reserva = new Reserva();
        return $reserva->selectAll($token);
    }

    function selectById($id)
    {
        $token = $this->getBearerToken();
        $reserva = new Reserva();
        return $reserva->selectById($id, $token);
    }

    function cadastrar($destinatario, $observacao, $horario_inicio, $horario_fim, $nome_sala)
    {
        $token = $this->getBearerToken();
        $reserva = new Reserva();
        return $reserva->cadastrar($destinatario, $observacao, $horario_inicio, $horario_fim, $nome_sala, $token);
    }

    function atualizar($id_reserva, $destinatario, $observacao, $horario_inicio, $horario_fim, $nome_sala)
    {
        $token = $this->getBearerToken();
        $reserva = new Reserva();
        return $reserva->atualizar($id_reserva, $destinatario, $observacao, $horario_inicio, $horario_fim, $nome_sala, $token);
    }

    function atualizarStatus($id_reserva, $status)
    {
        $token = $this->getBearerToken();
        $reserva = new Reserva();
        return $reserva->atualizarStatus($id_reserva, $status, $token);
    }

    function excluir($id)
    {
        $token = $this->getBearerToken();
        $reserva = new Reserva();
        return $reserva->excluir($id, $token);
    }
}