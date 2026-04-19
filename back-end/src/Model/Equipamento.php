<?php
namespace App\Model;
use App\Database\Connection;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Equipamento
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
            $db = new Connection();
            $sql = 'SELECT * FROM equipamentos';
            return $db->query($sql);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function selectById($id, $token)
    {
        try {
            $this->validateToken($token);
            $db = new Connection();
            $sql = 'SELECT * FROM equipamentos WHERE id_equipamento = :id';
            return $db->query($sql, ['id' => $id]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function cadastrar($nome_equipamento, $descricao_equipamento, $quantidade_equipamento, $token)
    {
        try {
            $this->validateToken($token);
            $db = new Connection();
            $sql = 'INSERT INTO equipamentos ( 
                nome_equipamento, 
                descricao_equipamento, 
                quantidade_equipamento
            ) VALUES (
                :nome_equipamento, 
                :descricao_equipamento, 
                :quantidade_equipamento 
            )';
            return $db->query_insert($sql, [
                'nome_equipamento' => $nome_equipamento,
                'descricao_equipamento' => $descricao_equipamento,
                'quantidade_equipamento' => $quantidade_equipamento
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function atualizar($id, $nome_equipamento, $descricao_equipamento, $quantidade_equipamento, $token)
    {
        try {
            $this->validateToken($token);
            $db = new Connection();
            $sql = 'UPDATE equipamentos SET 
                nome_equipamento = :nome_equipamento, 
                descricao_equipamento = :descricao_equipamento, 
                quantidade_equipamento = :quantidade_equipamento
                WHERE id_equipamento = :id';
            return $db->query_update($sql, [
                'id' => $id,
                'nome_equipamento' => $nome_equipamento,
                'descricao_equipamento' => $descricao_equipamento,
                'quantidade_equipamento' => $quantidade_equipamento
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function excluir($id, $token)
    {
        try {
            $this->validateToken($token);
            $db = new Connection();
            $sql = 'DELETE FROM equipamentos WHERE id_equipamento = :id';
            return $db->query_delete($sql, ['id' => $id]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}