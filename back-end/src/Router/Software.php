<?php

namespace App\Router;

use App\Controller\SoftwareController;
use Exception;

function addSoftwareRoutes($router)
{
    $router->mount('/Software', function () use ($router) {
        $router->get('/', function () {
            try {
                $software = new SoftwareController();
                if ($software = $software->selectAll()) {
                    echo json_encode($software);
                } else {
                    echo json_encode(['error' => 'Nenhum software encontrado']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });

        $router->get('/{id}', function ($id) {
            try {
                $software = new SoftwareController();
                if ($software = $software->selectById($id)) {
                    echo json_encode($software);
                } else {
                    echo json_encode(['error' => 'Software não encontrado']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });

        $router->post('/cadastrar', function () {
            try {
                $software = new SoftwareController();
                $data = json_decode(file_get_contents('php://input'), true);
                if ($software->cadastrar($data['id_software'], $data['nome_software'], $data['versao_software'], $data['descricao_software'], $data['preco_software'])) {
                    echo json_encode(['success' => 'Software cadastrado com sucesso']);
                } else {
                    echo json_encode(['error' => 'Erro ao cadastrar software']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });

        $router->put('/{id}', function ($id) {
            try {
                $software = new SoftwareController();
                $data = json_decode(file_get_contents('php://input'), true);
                if ($software->atualizar($data['id_software'], $data['nome_software'], $data['versao_software'], $data['descricao_software'], $data['preco_software'])) {
                    echo json_encode(['success' => 'Software atualizado com sucesso']);
                } else {
                    echo json_encode(['error' => 'Erro ao atualizar software']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });

        $router->delete('/{id}', function ($id) {
            try {
                $software = new SoftwareController();
                if ($software->excluir($id)) {
                    echo json_encode(['success' => 'Software excluído com sucesso']);
                } else {
                    echo json_encode(['error' => 'Erro ao excluir software']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        });
    });
}