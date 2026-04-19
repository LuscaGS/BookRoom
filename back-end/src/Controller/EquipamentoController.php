<?php

namespace App\Controller;
use App\Model\Equipamento;
use Exception;

class EquipamentoController
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
        $equipamento = new Equipamento();
        return $equipamento->selectAll($token);
    }

    function selectById($id)
    {
        $token = $this->getBearerToken();
        $equipamento = new Equipamento();
        return $equipamento->selectById($id, $token);
    }

    function cadastrar($nome_equipamento, $descricao_equipamento, $quantidade_equipamento)
    {
        $token = $this->getBearerToken();
        $equipamento = new Equipamento();
        return $equipamento->cadastrar($nome_equipamento, $descricao_equipamento, $quantidade_equipamento, $token);
    }

    function atualizar($id, $nome_equipamento, $descricao_equipamento, $quantidade_equipamento)
    {
        $token = $this->getBearerToken();
        $equipamento = new Equipamento();
        return $equipamento->atualizar($id, $nome_equipamento, $descricao_equipamento, $quantidade_equipamento, $token);
    }

    function excluir($id)
    {
        $token = $this->getBearerToken();
        $equipamento = new Equipamento();
        return $equipamento->excluir($id, $token);
    }
}