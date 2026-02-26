# 📋 Gestão de Projetos

![License](https://img.shields.io/badge/license-MIT-green)
![Laravel](https://img.shields.io/badge/Laravel-11.x-red)
![Vue.js](https://img.shields.io/badge/Vue.js-3.x-brightgreen)
![Inertia](https://img.shields.io/badge/Inertia.js-latest-blue)

Sistema completo para **gerenciamento de projetos, tarefas e usuários**, desenvolvido com Laravel, Vue.js e Inertia.js. Oferece uma interface moderna e reativa para facilitar o acompanhamento e a organização de equipes e atividades.

---

## ✨ Funcionalidades

- ✅ **Autenticação de usuários** (registro, login, recuperação de senha)
- ✅ **Gerenciamento de Projetos** (criar, editar, visualizar, excluir)
- ✅ **Gerenciamento de Tarefas** (criar, atribuir, definir prazos, status)
- ✅ **Atribuição de usuários a projetos e tarefas**
- ✅ **Filtros e buscas avançadas**
- ✅ **Painel administrativo** com visão geral dos projetos e tarefas
- ✅ **Perfis de usuário** (administrador, gerente, membro)
- ✅ **Notificações** (por e-mail ou no sistema)
- ✅ **API REST** para integração com outros sistemas (opcional)

---

## Tecnologias Utilizadas

- **Backend:** [Laravel 11](https://laravel.com/) (PHP 8.2+)
- **Frontend:** [Vue.js 3](https://vuejs.org/) + [Inertia.js](https://inertiajs.com/)
- **Build:** [Vite](https://vitejs.dev/)
- **Banco de Dados:** MySQL / PostgreSQL / SQLite (configurável)
- **Estilização:** CSS customizado ou framework opcional (ex.: Tailwind CSS - a definir)
- **Autenticação:** Laravel Breeze ou Jetstream (conforme implementação)

---

## Pré-requisitos

Antes de começar, você precisará ter instalado em sua máquina:

- [PHP](https://www.php.net/) >= 8.2
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) >= 18.x
- [NPM](https://www.npmjs.com/) ou [Yarn](https://yarnpkg.com/)
- [MySQL](https://www.mysql.com/) (ou outro banco de dados compatível)

---

## Instalação e Configuração

Siga os passos abaixo para rodar o projeto localmente:

### 1. Clone o repositório
```bash
git clone https://github.com/kelvinjunior77/gestao-de-projetos.git
cd gestao-de-projetos
