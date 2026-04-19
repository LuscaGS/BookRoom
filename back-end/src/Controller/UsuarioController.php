<?php

namespace App\Controller;

use App\Model\Usuario;
use App\Model\UsuarioComum;
use App\Model\Administrador;
use App\Model\AdministradorSupremo;
use Exception;

class UsuarioController
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

    // Funções para Usuario.php
    function login($login, $senha)
    {
        $usuario = new Usuario();
        return $usuario->login($login, $senha);
    }

    function cadastrar($nome, $login, $email, $senha)
    {
        $usuario = new Usuario();
        return $usuario->cadastrar($nome, $login, $email, $senha);
    }


    // Funções para AdministradorSupremo.php
    function selectAll()
    {
        $token = $this->getBearerToken();
        $adm_super = new AdministradorSupremo();
        return $adm_super->selectAll($token);
    }

    function selectById($id)
    {
        $token = $this->getBearerToken();
        $adm_super = new AdministradorSupremo();
        return $adm_super->selectById($token, $id);
    }

    function atualizar($id, $nome, $login, $email, $senha, $perfil)
    {
        $token = $this->getBearerToken();
        $adm_super = new AdministradorSupremo();
        return $adm_super->atualizar($token, $id, $nome, $login, $email, $senha, $perfil);
    }

    function excluir($id)
    {
        $token = $this->getBearerToken();
        $adm_super = new AdministradorSupremo();
        return $adm_super->excluir($token, $id);
    }
}

