# 📚 BookRoom - Backend

Sistema backend para gerenciamento e reserva de salas, equipamentos e softwares.

## 📖 Sobre o projeto

O **BookRoom** é uma API backend desenvolvida em PHP com o objetivo de organizar o uso de salas e recursos dentro de uma instituição (como escolas ou empresas).

O sistema permite controlar:

- Salas
- Reservas
- Usuários
- Equipamentos
- Softwares disponíveis

A aplicação segue uma estrutura organizada em camadas, facilitando manutenção e expansão.

---

## ⚙️ Tecnologias utilizadas

- PHP (sem framework)
- SQLite (banco de dados local)
- Composer
- HTML/CSS (estrutura básica em `public/`)

---

## 🧱 Arquitetura do projeto

O projeto segue um padrão inspirado em MVC:

```
src/
 ├── Controller/   # Regras de negócio
 ├── Model/        # Representação dos dados
 ├── Router/       # Rotas da API
 └── Database/     # Conexão e banco SQLite
```

### Principais entidades:

- Usuário
- Sala
- Reserva
- Equipamento
- Software
- Administrador Supremo

---

## 🚀 Funcionalidades

- Cadastro de salas  
- Cadastro de usuários  
- Criação e gerenciamento de reservas  
- Controle de softwares disponíveis  
- Gerenciamento de equipamentos  
- Controle administrativo  

---

## 🗂️ Estrutura de pastas

```
back-end/
 ├── public/              
 ├── src/
 │    ├── Controller/
 │    ├── Model/
 │    ├── Router/
 │    └── Database/
 ├── composer.json
 └── index.html
```

---

## 🛠️ Como executar o projeto

### Pré-requisitos

- PHP 7.4 ou superior  
- Composer  

### Passos

```bash
# Clonar o repositório
git clone https://github.com/LuscaGS/BookRoom

# Entrar na pasta
cd BookRoom/back-end

# Instalar dependências
composer install

# Rodar servidor local
php -S localhost:8000
```

Acesse no navegador:
```
http://localhost:8000
```

---

## 🗄️ Banco de dados

O projeto utiliza SQLite com arquivo local:

```
src/Database/database.db
```

Script de criação:

```
src/Database/database.sql
```

---

## 🔌 Rotas da API

As rotas estão organizadas por entidade:

- /usuarios  
- /salas  
- /reservas  
- /equipamentos  
- /software  

Operações disponíveis:

- GET (listar)  
- POST (criar)  
- PUT (atualizar)  
- DELETE (remover)  

---

## 📌 Melhorias futuras

- Autenticação com JWT  
- Validação de dados mais robusta  
- Interface frontend completa  
- Integração com MySQL ou PostgreSQL  
- Logs e monitoramento  

---

## 👨‍💻 Autor

Desenvolvido pela equipe de estudantes do 2° Semestre de Desenvolvimento de Software Multiplataforma

---

## 📄 Licença

Este projeto está sob a licença MIT.
