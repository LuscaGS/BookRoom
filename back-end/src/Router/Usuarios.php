<?php

namespace App\Router;

use App\Controller\UsuarioController;

function addUsuarioRoutes($router)
{
    $router->mount('/Usuarios', function () use ($router) {
        $router->get('/', function () {
            $usuario = new UsuarioController();
            echo json_encode($usuario->selectAll());
        });

        $router->get('/{id}', function ($id) {
            $usuario = new UsuarioController();
            echo json_encode($usuario->selectById($id));
        });

        $router->post('/cadastrar', function () {
            $usuario = new UsuarioController();
            $data = json_decode(file_get_contents('php://input'), true);
            echo json_encode($usuario->cadastrar($data['nome'], $data['login'], $data['email'], $data['senha']));
        });

        $router->post('/login', function () {
            $usuario = new UsuarioController();
            $data = json_decode(file_get_contents('php://input'), true);
            echo json_encode($usuario->login($data['login'], $data['senha']));
        });

        $router->put('/{id}', function ($id) {
            $usuario = new UsuarioController();
            $data = json_decode(file_get_contents('php://input'), true);
            echo json_encode($usuario->atualizar($id, $data['nome'], $data['login'], $data['email'], $data['senha'], $data['perfil']));
        });

        

        $router->delete('/{id}', function ($id) {
            $usuario = new UsuarioController();
            echo json_encode($usuario->excluir($id));
        });
    });
}