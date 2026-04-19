<?php

namespace App\Router;

use App\Controller\EquipamentoController;
use Exception;

function addEquipamentoRoutes($router)
{
    $router->mount('/Equipamento', function () use ($router) {
        $router->get('/', function () {
            try {
                $equipamento = new EquipamentoController();
                if ($equipamento = $equipamento->selectAll()) {
                    echo json_encode($equipamento);
                } else {
                    echo json_encode(['error' => 'Nenhum equipamento encontrado']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });

        $router->get('/{id}', function ($id) {
            try {
                $equipamento = new EquipamentoController();
                if ($equipamento = $equipamento->selectById($id)) {
                    echo json_encode($equipamento);
                } else {
                    echo json_encode(['error' => 'Equipamento não encontrado']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });

        $router->post('/cadastrar', function () {
            try {
                $equipamento = new EquipamentoController();
                $data = json_decode(file_get_contents('php://input'), true);
                if ($equipamento->cadastrar($data['nome_equipamento'], $data['descricao_equipamento'], $data['quantidade_equipamento'])) {
                    echo json_encode(['success' => 'Equipamento cadastrado com sucesso']);
                } else {
                    echo json_encode(['error' => 'Erro ao cadastrar equipamento']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });

        $router->put('/{id}', function ($id) {
            try {
                $equipamento = new EquipamentoController();
                $data = json_decode(file_get_contents('php://input'), true);
                if ($equipamento->atualizar($data['id_equipamento'], $data['nome_equipamento'], $data['descricao_equipamento'], $data['quantidade_equipamento'])) {
                    echo json_encode(['success' => 'Equipamento atualizado com sucesso']);
                } else {
                    echo json_encode(['error' => 'Erro ao atualizar equipamento']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });

        $router->delete('/{id}', function ($id) {
            try {
                $equipamento = new EquipamentoController();
                if ($equipamento->excluir($id)) {
                    echo json_encode(['success' => 'Equipamento excluído com sucesso']);
                } else {
                    echo json_encode(['error' => 'Erro ao excluir equipamento']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });
    });
}