<?php

namespace App\Controller;
use App\Model\Software;
use Exception;

class SoftwareController
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
        $software = new Software();
        return $software->selectAll($token);
    }

    function selectById($id)
    {
        $token = $this->getBearerToken();
        $software = new Software();
        return $software->selectById($id, $token);
    }

    function cadastrar($id, $nome_software, $versao_software, $descricao_software, $preco_software)
    {
        $token = $this->getBearerToken();
        $software = new Software();
        return $software->cadastrar($id, $nome_software, $versao_software, $descricao_software, $preco_software, $token);
    }

    function atualizar($id, $nome_software, $versao_software, $descricao_software, $preco_software)
    {
        $token = $this->getBearerToken();
        $software = new Software();
        return $software->atualizar($id, $nome_software, $versao_software, $descricao_software, $preco_software, $token);
    }

    function excluir($id)
    {
        $token = $this->getBearerToken();
        $software = new Software();
        return $software->excluir($id, $token);
    }
}