<?php

namespace App\Model;

use App\Database\Connection;
use Exception;
use Firebase\JWT\JWT;

class Usuario
{
    protected $id;
    protected $nome;
    protected $login;
    protected $email;
    protected $senha;
    private $secretKey = 'sua_chave_secreta';

    function cadastrar($nome, $login, $email, $senha)
    {
        $hasheada = password_hash($senha, PASSWORD_DEFAULT);
        try {
            $db = new Connection();
            $sql = 'INSERT INTO usuarios (nome_usuario, login, email, senha) VALUES (:nome, :login, :email, :senha)';
            try {
                $db->query_insert($sql, ['nome' => $nome, 'login' => $login, 'email' => $email, 'senha' => $hasheada]);
                return ['success' => 'Usuário cadastrado com sucesso'];
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function login($login, $senha)
    {
        try {
            $db = new Connection();
        
            $sql = 'SELECT * FROM usuarios WHERE login = :login';
            $usuario = $db->query($sql, ['login' => $login]);

            if (count($usuario) > 0) {
                $senha_verificada = password_verify($senha, $usuario[0]['senha']);
                if ($senha_verificada) {
                    $payload = [
                        'iss' => "localhost:80", // Issuer
                        'aud' => "fatec-itaquera.com", // Audience
                        'iat' => time(), // Issued at
                        'nbf' => time(), // Not before
                        'exp' => time() + (60 * 60), // Expiration time (1 hour)
                        'data' => [
                            'id' => $usuario[0]['id_usuario'],
                            'login' => $usuario[0]['login'],
                            'perfil' => $usuario[0]['perfil']
                        ]
                    ];
                    $jwt = JWT::encode($payload, $this->secretKey, 'HS256');
                    return ['success' => 'Login efetuado com sucesso', 'token' => $jwt, 'id' => $usuario[0]['id_usuario'], 'user' => $usuario[0]['nome_usuario'], 'login' => $usuario[0]['login'], 'perfil' => $usuario[0]['perfil']];
                } else {
                    return ['error' => 'Login ou senha inválidos'];
                }
            } else {
                return ['error' => 'Login ou senha inválidos'];
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
