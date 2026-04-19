<?php

namespace App\Controller;

use App\Model\Sala;
use Exception;

class SalaController
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
        $sala = new Sala();
        return $sala->selectAll($token);
    }

    function selectById($id)
    {
        $token = $this->getBearerToken();
        $sala = new Sala();
        return $sala->selectById($id, $token);
    }

    function cadastrar($nome_sala, $numero_sala, $capacidade_sala, $id_equipamento)
    {
        $token = $this->getBearerToken();
        $sala = new Sala();
        return $sala->cadastrar($nome_sala, $numero_sala, $capacidade_sala, $id_equipamento, $token);
    }

    function atualizar($id, $nome_sala, $numero_sala, $capacidade_sala, $id_equipamento)
    {
        $token = $this->getBearerToken();
        $sala = new Sala();
        return $sala->atualizar($id, $nome_sala, $numero_sala, $capacidade_sala, $id_equipamento, $token);
    }

    function excluir($id)
    {
        $token = $this->getBearerToken();
        $sala = new Sala();
        return $sala->excluir($id, $token);
    }
}
