<?php

namespace App\Router;

use App\Controller\SalaController;
use Exception;

function addSalaRoutes($router)
{
    $router->mount('/Sala', function () use ($router) {
        $router->get('/', function () {
            try {
                $sala = new SalaController();
                if ($salas = $sala->selectAll()) {
                    echo json_encode(['success' => 'Salas encontradas', 'result' => $salas]);
                } else {
                    echo json_encode(['error' => 'Nenhuma sala encontrada', 'result' => $salas]);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });

        $router->get('/{id}', function ($id) {
            try {
                $sala = new SalaController();
                if ($sala = $sala->selectById($id)) {
                    echo json_encode($sala);
                } else {
                    echo json_encode(['error' => 'Reserva não encontrada']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });

        $router->post('/cadastrar', function () {
            try {
                $sala = new SalaController();
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $sala->cadastrar($data['nome_sala'], $data['numero_sala'], $data['capacidade_sala'], $data['id_equipamento']);
                if ($result) {
                    echo json_encode(['success' => 'Sala cadastrada com sucesso', 'result' => $result]);
                } else {
                    echo json_encode(['error' => 'Erro ao cadastrar sala', 'result' => $result]);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });

        $router->put('/{id}', function ($id) {
            try {
                $sala = new SalaController();
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $sala->atualizar($id, $data['nome_sala'], $data['numero_sala'], $data['capacidade_sala'], $data['id_equipamento']);
                if ($result) {
                    echo json_encode(['success' => 'Sala atualizada com sucesso', 'result' => $result]);
                } else {
                    echo json_encode(['error' => 'Erro ao atualizar sala', 'result' => $result]);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });

        $router->delete('/{id}', function ($id) {
            try {
                $sala = new SalaController();
                $result = $sala->excluir($id);
                if ($result) {
                    echo json_encode(['success' => 'Sala deletada com sucesso', 'result' => $result]);
                } else {
                    echo json_encode(['error' => 'Erro ao deletar sala', 'result' => $result]);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });
    });
}
