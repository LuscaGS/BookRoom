<?php
namespace App\Model;
use App\Database\Connection;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Software
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
            $sql = 'SELECT * FROM software';
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
            $sql = 'SELECT * FROM software WHERE id_software = :id';
            return $db->query($sql, ['id' => $id]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function cadastrar($id, $nome_software, $versao_software, $descricao_software, $preco_software, $token)
    {
        try {
            $this->validateToken($token);
            $db = new Connection();
            $sql = 'INSERT INTO software (
                id_software, 
                nome_software, 
                versao_software, 
                descricao_software, 
                preco_software
            ) VALUES (
                :id, 
                :nome_software, 
                :versao_software, 
                :descricao_software, 
                :preco_software
            )';
            return $db->query_insert($sql, [
                'id' => $id,
                'nome_software' => $nome_software,
                'versao_software' => $versao_software,
                'descricao_software' => $descricao_software,
                'preco_software' => $preco_software
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function atualizar($id, $nome_software, $versao_software, $descricao_software, $preco_software, $token)
    {
        try {
            $this->validateToken($token);
            $db = new Connection();
            $sql = 'UPDATE software SET 
                nome_software = :nome_software, 
                versao_software = :versao_software, 
                descricao_software = :descricao_software, 
                preco_software = :preco_software 
                WHERE id_software = :id';
            return $db->query_update($sql, [
                'id' => $id,
                'nome_software' => $nome_software,
                'versao_software' => $versao_software,
                'descricao_software' => $descricao_software,
                'preco_software' => $preco_software
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
            $sql = 'DELETE FROM software WHERE id_software = :id';
            return $db->query_delete($sql, ['id' => $id]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}