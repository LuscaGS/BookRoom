<?php

namespace App\Model;

use App\Database\Connection;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Sala
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
            if ($decoded->perfil == 'administrador_supremo' || $decoded->perfil == 'administrador') {
                $db = new Connection();
                $sql = 'SELECT * FROM sala';
                if ($salas = $db->query($sql)) {
                    return $salas;
                } else {
                    throw new Exception('Nenhuma sala encontrada');
                }
            } else {
                throw new Exception('Acesso negado');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function selectById($id, $token)
    {
        try {
            $this->validateToken($token);
            $decoded = $this->validateToken($token);
            if ($decoded->perfil == 'administrador_supremo' || $decoded->perfil == 'administrador') {
                $db = new Connection();
                $sql = 'SELECT * FROM sala WHERE id_sala = :id';
                try {
                    if ($sala = $db->query($sql, ['id' => $id])) {
                        return $sala;
                    } else {
                        throw new Exception('Sala não encontrada');
                    }
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } else {
                throw new Exception('Acesso negado');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function cadastrar($nome_sala, $numero_sala, $capacidade_sala, $id_equipamento, $token)
    {
        try {
            $this->validateToken($token);
            $decoded = $this->validateToken($token);
            if ($decoded->perfil == 'administrador_supremo' || $decoded->perfil == 'administrador') {
                try{
                    $db = new Connection();
                    $sql = 'INSERT INTO sala (nome_sala, numero_sala, capacidade_sala, id_equipamento) VALUES (:nome_sala, :numero_sala, :capacidade_sala, :id_equipamento)';
                    if ($db->query_insert($sql, [
                        'nome_sala' => $nome_sala,
                        'numero_sala' => $numero_sala,
                        'capacidade_sala' => $capacidade_sala,
                        'id_equipamento' => $id_equipamento
                    ])) {
                        return ['success' => 'Sala cadastrada com sucesso'];
                    } else {
                        throw new Exception('Erro ao cadastrar sala');
                    }
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } else {
                throw new Exception('Acesso negado');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function atualizar($id, $nome_sala, $numero_sala, $capacidade_sala, $id_equipamento, $token)
{
    try {
        $this->validateToken($token);
        $decoded = $this->validateToken($token);
        if ($decoded->perfil == 'administrador_supremo' || $decoded->perfil == 'administrador') {
            try{
                $db = new Connection();
                $sql = 'UPDATE sala SET nome_sala = :nome_sala, numero_sala = :numero_sala, capacidade_sala = :capacidade_sala, id_equipamento = :id_equipamento WHERE id_sala = :id';
                if ($db->query_update($sql, [
                    'id' => $id,
                    'nome_sala' => $nome_sala,
                    'numero_sala' => $numero_sala,
                    'capacidade_sala' => $capacidade_sala,
                    'id_equipamento' => $id_equipamento
                ])) {
                    return ['success' => 'Sala atualizada com sucesso'];
                } else {
                    throw new Exception('Erro ao atualizar sala');
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Acesso negado');
        }
    } catch (Exception $e) {
        return $e->getMessage();
    }
}


    function excluir($id, $token)
    {
        try {
            $this->validateToken($token);
            $decoded = $this->validateToken($token);
            if ($decoded->perfil == 'administrador_supremo' || $decoded->perfil == 'administrador') {
                $db = new Connection();
                $sql = 'DELETE FROM sala WHERE id_sala = :id';
                if ($db->query_delete($sql, ['id' => $id])) {
                    return ['success' => 'Sala excluída com sucesso'];
                } else {
                    throw new Exception('Erro ao excluir sala');
                }
            } else {
                throw new Exception('Acesso negado');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}