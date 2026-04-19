<?php

namespace App\Model;

use App\Database\Connection;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class Reserva
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
                $sql = 'SELECT * FROM reserva';
                return $db->query($sql);
            }
            
            $db = new Connection();
            $sql = 'SELECT * FROM reserva WHERE id_usuario = :id_usuario';
            if ($reservas = $db->query($sql, ['id_usuario' => $decoded->id])) {
                return $reservas;
            }
            throw new Exception('Nenhuma reserva encontrada');

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function selectById($id, $token)
    {
        try{
            $this->validateToken($token);
            $decoded = $this->validateToken($token);
            if ($decoded->perfil == 'administrador_supremo' || $decoded->perfil == 'administrador') {
                $db = new Connection();
                $sql = 'SELECT * FROM reserva WHERE id_reserva = :id';
                if ($reserva = $db->query($sql, ['id' => $id])) {
                    return $reserva;
                }
                throw new Exception('Reserva não encontrada');
            }

            $db = new Connection();
            $sql = 'SELECT * FROM reserva WHERE id_reserva = :id AND id_usuario = :id_usuario';
            if ($reserva = $db->query($sql, ['id' => $id, 'id_usuario' => $decoded->id])) {
                return $reserva;
            }
            throw new Exception('Reserva não encontrada');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function cadastrar($destinatario, $observacao, $horario_inicio, $horario_fim, $nome_sala, $token)
    {
        try {
            $this->validateToken($token);
            $decoded = $this->validateToken($token);
            $db = new Connection();
            $sql = 'INSERT INTO reserva (destinatario_reserva, observacao, horario_inicio, horario_fim, id_usuario, nome_sala) VALUES (:destinatario, :observacao, :horario_inicio, :horario_fim, :id_usuario, :nome_sala)';
            if ($db->query_insert($sql, [
                'destinatario' => $destinatario,
                'observacao' => $observacao,
                'horario_inicio' => $horario_inicio,
                'horario_fim' => $horario_fim,
                'id_usuario' => $decoded->id,
                'nome_sala' => $nome_sala
            ])) {
                return ['success' => 'Reserva cadastrada com sucesso', $decoded->id];
            }
            throw new Exception('Erro ao cadastrar reserva' , $decoded->id);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function atualizar($id_reserva, $destinatario, $observacao, $horario_inicio, $horario_fim, $nome_sala, $token)
    {
        try {
            $this->validateToken($token);
            $decoded = $this->validateToken($token);
            if($decoded->perfil == 'administrador_supremo' || $decoded->perfil == 'administrador') {
                $db = new Connection();
                $sql = 'UPDATE reserva SET destinatario_reserva = :destinatario, observacao = :observacao, horario_inicio = :horario_inicio, horario_fim = :horario_fim, nome_sala = :nome_sala WHERE id_reserva = :id_reserva';
                if ($db->query_update($sql, [
                    'id_reserva' => $id_reserva,
                    'destinatario' => $destinatario,
                    'observacao' => $observacao,
                    'horario_inicio' => $horario_inicio,
                    'horario_fim' => $horario_fim,
                    'nome_sala' => $nome_sala
                ])) {
                    return ['success' => 'Reserva atualizada com sucesso'];
                }
                throw new Exception('Erro ao atualizar reserva');
            }

            elseif($decoded->perfil == 'usuario') {
                $db = new Connection();
                $sql = 'UPDATE reserva SET destinatario_reserva = :destinatario, observacao = :observacao, horario_inicio = :horario_inicio, horario_fim = :horario_fim, nome_sala = :nome_sala WHERE id_reserva = :id_reserva AND id_usuario = :id_usuario';
                if ($db->query_update($sql, [
                    'id_reserva' => $id_reserva,
                    'destinatario' => $destinatario,
                    'observacao' => $observacao,
                    'horario_inicio' => $horario_inicio,
                    'horario_fim' => $horario_fim,
                    'id_usuario' => $decoded->id,
                    'nome_sala' => $nome_sala
                ])) {
                    return ['success' => 'Reserva atualizada com sucesso'];
                }
                throw new Exception('Erro ao atualizar reserva');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function atualizarStatus($id_reserva, $status, $token)
    {
        try {
            $this->validateToken($token);
            $decoded = $this->validateToken($token);
            if($decoded->perfil == 'administrador_supremo' || $decoded->perfil == 'administrador') {
                $db = new Connection();
                $sql = 'UPDATE reserva SET status = :status WHERE id_reserva = :id_reserva';
                try {
                    if ($db->query_update($sql, ['id_reserva' => $id_reserva, 'status' => $status])) {
                        return ['success' => 'Status da reserva atualizado com sucesso'];
                    }
                    throw new Exception('Erro ao atualizar status da reserva');
                } catch (Exception $e) {
                    return $e->getMessage();
                }
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
            if($decoded->perfil == 'administrador_supremo' || $decoded->perfil == 'administrador') {
                $db = new Connection();
                $sql = 'DELETE FROM reserva WHERE id_reserva = :id';
                if ($db->query_delete($sql, ['id' => $id])) {
                    return ['success' => 'Reserva excluída com sucesso'];
                }
                throw new Exception('Erro ao excluir reserva');
            }

            elseif($decoded->perfil == 'usuario') {
                $db = new Connection();
                $sql = 'DELETE FROM reserva WHERE id_reserva = :id AND id_usuario = :id_usuario';
                if ($db->query_delete($sql, ['id' => $id, 'id_usuario' => $decoded->id])) {
                    return ['success' => 'Reserva excluída com sucesso'];
                }
                throw new Exception('Erro ao excluir reserva');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}