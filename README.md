# CamUp 🚀

CamUp é um projeto **educacional e prático** que simula o desenvolvimento de um sistema web de gestão (ERP) para pequenas e médias empresas, seguindo **processos, arquitetura e boas práticas usadas no mercado de trabalho**.

O objetivo do projeto é:

* Evoluir desenvolvedores iniciantes/júnior
* Oferecer experiência real com **Docker, Git, Pull Requests, Code Review e organização de projeto**

---

## 📌 Visão geral do projeto

O CamUp será um sistema **modular** de gestão para diferentes tipos de negócio (ex: dedetização, joalheria, etc.), onde cada empresa poderá ativar módulos conforme sua necessidade.

Funcionalidades base (MVP):

* Autenticação de usuários
* Gestão de empresas
* Estrutura modular
* Base para financeiro, agenda, colaboradores, etc.

---

## 🧱 Stack utilizada

* **Backend:** PHP 8.2 + Laravel
* **Banco de dados:** MySQL 8
* **Servidor web:** Nginx
* **Ambiente:** Docker + Docker Compose
* **Frontend:** Blade + Tailwind CSS
* **Controle de versão:** Git + GitHub

---

## ⚠️ Pré-requisitos

Antes de começar, você precisa ter instalado na sua máquina:

* **Git**
  [https://git-scm.com/](https://git-scm.com/)

* **Docker**
  [https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)

> 💡 Importante: **Não é necessário instalar PHP, MySQL ou Nginx localmente.** Tudo roda via Docker.

---

## 📥 Clonando o projeto

Abra o terminal e execute:

```bash
cd ~
git clone git@github.com:LucasAlbuquerque04/camup-system.git
cd camup-system
```

Estrutura esperada:

```text
camup-system/
├── docker/
├── docker-compose.yml
├── README.md
└── src/
```

---

## 🐳 Subindo o ambiente com Docker

Na raiz do projeto (`camup-system`), execute:

```bash
docker compose up -d --build
```

Esse comando irá:

* Criar os containers (PHP, Nginx, MySQL)
* Instalar o Composer dentro do container
* Subir o ambiente local

Para verificar se os containers estão rodando:

```bash
docker ps
```

---

## ⚙️ Configuração inicial do Laravel

Entre no container da aplicação:

```bash
docker compose exec app bash
```

### ⚠️ IMPORTANTE — ordem dos comandos

> **Nunca execute `php artisan` antes de rodar `composer install`.**

### 1️⃣ Instalar dependências PHP (obrigatório)

```bash
composer install
```

Isso irá criar a pasta `vendor/`, necessária para o Laravel funcionar.

---

### 2️⃣ Copiar o arquivo de ambiente

```bash
cp .env.example .env
```

---

### 3️⃣ Gerar a chave da aplicação

```bash
php artisan key:generate
```

---

### 4️⃣ Rodar as migrations

> ℹ️ As tabelas de **cache, sessão e filas já existem por padrão neste projeto**.

```bash
php artisan migrate
```

---

### 5️⃣ Ajustar permissões (muito importante)

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

Saia do container:

```bash
exit
```

---

## 🌐 Acessando o sistema

Abra o navegador e acesse:

```
http://localhost:8010
```

Você deverá ver a tela padrão do Laravel.

---

## 🧪 Comandos úteis

### Parar o ambiente

```bash
docker compose down
```

### Subir novamente

```bash
docker compose up -d
```

### Ver logs

```bash
docker compose logs -f
```

### Acessar o container da aplicação

```bash
docker compose exec app bash
```

---

## 🔀 Fluxo de trabalho (Git)

Seguimos um fluxo parecido com empresas:

* ❌ Nunca trabalhar direto na `main`
* Criar branch para cada tarefa:

```bash
git checkout -b feat/nome-da-feature
```

* Commitar com mensagens claras:

```bash
git commit -m "feat: adicionar autenticação"
```

* Push da branch:

```bash
git push origin feat/nome-da-feature
```

* Abrir Pull Request no GitHub
* Fazer code review
* Merge na `main`

---

## 📚 Observações importantes

* Nunca versionar o arquivo `.env`
* Sempre usar Docker
* Sempre criar branch
* Sempre abrir PR

---

## 🎯 Objetivo educacional

Este projeto **não é apenas sobre código**.

Ele existe para ensinar:

* Como projetos reais funcionam
* Como trabalhar em equipe
* Como lidar com ambiente, erros e processos

> Se você é iniciante: vá com calma, leia, teste e pergunte.

---

## 🤝 Contribuição

Sugestões, melhorias e dúvidas são bem-vindas via **issues** ou **pull requests**.

---

🚀 **Bem-vindo ao CamUp. Aqui a ideia é aprender do jeito certo.**
