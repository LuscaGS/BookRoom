# Sistema de Cadastro de Reservas de Salas de Aula

## Descrição

## Tecnologias Utilizadas
- PHP 8
- Composer
- MySQL

## Como Usar

### Passos para Iniciar o Projeto Localmente

1. **Instalar Dependências**
   - Execute o comando abaixo no terminal para instalar todas as dependências necessárias:
     ```bash
     composer install
     ```

2. **Iniciar o Servidor Local**
   - Para iniciar o servidor local, use o seguinte comando:
     ```bash
     php -S localhost:80
     ```

3. **Acessar a Aplicação**
   - Abra o navegador e vá para:
     ```text
     http://localhost:80
     ```

**Nota:**
- Certifique-se de ter o Composer e o PHP instalados no seu sistema antes de executar os comandos acima.

## Postman
[Link](https://app.getpostman.com/join-team?invite_code=ceade3ccca6aafd05e148e412b8f5bef&target_code=f1ec94e150877067728285b121169ad1)

## 1. Usuários e Perfis

#### 1.1 Cadastro de Usuários

- **Todos** podem se cadastrar no sistema.
- Dados necessários para o cadastro:
  - `nome_usuario`
  - `email`,
  - `login`
  - `senha`
- Campos adicionais definidos automaticamente:
  - `data_criacao` (data e hora do cadastro)
  - `perfil` (definido como `comum`)

#### 1.2 Login de Usuários

- **Todos** podem fazer login no sistema.
- Dados necessários para o login:
  - `login`
  - `senha`

#### 1.3 Criar, Buscar, Listar, Atualizar e Excluir Usuários
- **Todos Usuários recebem o tipo de perfil no token.
- **Apenas usuários com perfil `administrador_supremo`** podem realizar as seguintes operações:
  - Listar todos os usuários.
  - Buscar usuários por ID.
  - Atualizar dados de usuários.
  - Excluir usuários.

## 2. Reservas

-----------------------------------

#### 2.1 Criação de Reservas

- **Todos** perfis podem criar reservas.
- Dados necessários para a criação de uma reserva:
  - `destinatario_reserva`
  - `observacao`
  - `horario_inicio`
  - `horario_fim`
  - `id_usuario` (Disponível no token)
  - `nome_sala`
- Campos adicionais definidos automaticamente:
  - `status` (definido inicialmente como `pendente`)

#### 2.2 Visualização e Edição de Reservas

- **Usuários com perfil `comum`** podem:
  - Visualizar suas próprias reservas.
  - Editar suas próprias reservas (mas não podem alterar o status da reserva).

#### 2.3 Status de Reservas

- **Usuários com perfil `administrador`** podem:
  - Alterar o status de uma reserva para `confirmada` ou `cancelada`.
  - Gerar relatórios de reservas.

#### 2.4 Operações Administrativas em Reservas

- **Usuários com perfil `administrador_supremo`** podem:
  - Criar reservas.
  - Listar todas as reservas.
  - Buscar reservas por ID.
  - Atualizar reservas.
  - Criar reservas.
  - Excluir reservas.

### 3. Especificações Técnicas

#### 3.1 Endpoints e Operações Permitidas

- **/usuarios**
  - `POST http://localhost/src/Router/Usuarios/cadastrar`: Cadastro de novos usuários (acessível por todos).
  - `POST http://localhost/src/Router/Usuarios/login`: Login de usuários (acessível por todos).
  - `GET http://localhost/src/Router/Usuarios`: Listar todos os usuários (apenas `administrador_supremo`).
  - `GET http://localhost/src/Router/Usuarios/{id}`: Buscar usuário por ID (apenas `administrador_supremo`).
  - `PUT http://localhost/src/Router/Usuarios/{id}`: Atualizar dados de usuário (apenas `administrador_supremo`).
  - `DELETE http://localhost/src/Router/Usuarios/{id}`: Excluir usuário (apenas `administrador_supremo`).

- **/reservas**
  - `POST http://localhost/src/Router/Reservas/cadastrar`: Criar nova reserva (acessível por todos).
  - `GET http://localhost/src/Router/Reservas`: Listar todas as reservas do usuário logado (acessível por todos).
  - `GET http://localhost/src/Router/Reservas/{id}`: Buscar reserva por ID (acessível por todos).
  - `PUT http://localhost/src/Router/Reservas/{id}`: Atualizar reserva (apenas pelo usuário que criou a reserva).
  - `DELETE http://localhost/src/Router/Reservas/{id}`: Excluir reserva (apenas `administrador_supremo`).
  - `PATCH http://localhost/src/Router/Reservas/{id}/status`: Alterar status da reserva (apenas `administrador`).

- **Salas, Equipamentos e Softwares** (Apenas para **`Administradores Supremos`**)

  - `GET http://localhost/src/Router/Sala`: Listar todas as salas

  - `POST http://localhost/src/Router/Sala`: Criar nova sala

  - `PATCH http://localhost/src/Router/Sala/{id}`: Atualizar uma sala (parcialmente)

  - `DELETE http://localhost/src/Router/Sala/{id}`: Excluir uma sala

  - `GET http://localhost/src/Router/equipamentos`: Listar todos os equipamentos

  - `POST http://localhost/src/Router/equipamentos`: Criar novo equipamento

  - `PATCH http://localhost/src/Router/equipamentos/{id}`: Atualizar um equipamento (parcialmente)

  - `DELETE http://localhost/src/Router/equipamentos/{id}`: Excluir um equipamento

  - `GET http://localhost/src/Router/softwares`: Listar todos os softwares

  - `POST http://localhost/src/Router/softwares`: Criar novo software

  - `PATCH http://localhost/src/Router/softwares/{id}`: Atualizar um software (parcialmente)

  - `DELETE http://localhost/src/Router/softwares/{id}`: Excluir um software
 
## Postman
[Link](https://app.getpostman.com/join-team?invite_code=ceade3ccca6aafd05e148e412b8f5bef&target_code=f1ec94e150877067728285b121169ad1)

