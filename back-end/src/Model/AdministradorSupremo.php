<?php

namespace App\Model;

use App\Database\Connection;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class AdministradorSupremo extends Usuario
{
    private $secretKey = 'sua_chave_secreta'; // Mesma chave secreta usada para gerar o token

    private function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return $decoded->data; // Retorna os dados do usuário do token
        } catch (Exception $e) {
            throw new Exception('Token inválido ou expirado');
        }
    }

    function selectAll($token)
    {
        try {
            $this->validateToken($token);
            $decoded = $this->validateToken($token);
            if ($decoded->perfil == 'administrador_supremo') {
                $db = new Connection();
                $sql = 'SELECT * FROM usuarios';
                try {
                    return $db->query($sql);
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } else {
                return ['error' => 'Acesso negado'];
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function selectById($token, $id)
    {
        try {
            $this->validateToken($token);
            $decoded = $this->validateToken($token);
            if ($decoded->perfil == 'administrador_supremo') {
                $db = new Connection();
                $sql = 'SELECT * FROM usuarios WHERE id_usuario = :id_usuario';
                try {
                    if ($usuario = $db->query($sql, ['id_usuario' => $id])) {
                        return $usuario;
                    }
                    return ['error' => 'Usuário não encontrado'];
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } else {
                return ['error' => 'Acesso negado'];
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }    

    function atualizar($token, $id_usuario, $nome, $login, $email, $senha, $perfil)
    {
        try {
            $this->validateToken($token);
            $decoded = $this->validateToken($token);
            if ($decoded->perfil == 'administrador_supremo') {
                $db = new Connection();
                $sql = 'UPDATE usuarios SET nome_usuario = :nome, login = :login, email = :email, senha = :senha, perfil = :perfil WHERE id_usuario = :id_usuario';
                try {
                    $hasheada = password_hash($senha, PASSWORD_DEFAULT);
                    $db->query_update($sql, ['nome' => $nome, 'login' => $login, 'email' => $email, 'senha' => $hasheada, 'perfil' => $perfil, 'id_usuario' => $id_usuario]);
                    return ['success' => 'Usuário atualizado com sucesso'];
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } else {
                return ['error' => 'Acesso negado'];
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function excluir($token, $id)
    {
        try {
            $this->validateToken($token);
            $decoded = $this->validateToken($token);
            if ($decoded->perfil == 'administrador_supremo') {
                $db = new Connection();
                $sql = 'DELETE FROM usuarios WHERE id_usuario = :id_usuario';
                try {
                    $db->query_delete($sql, ['id_usuario' => $id]);
                    return ['success' => 'Usuário excluído com sucesso'];
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } else {
                return ['error' => 'Acesso negado'];
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
