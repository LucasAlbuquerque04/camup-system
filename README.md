# CamUp 🚀

CamUp é um projeto educacional e prático que simula o desenvolvimento de um **Sistema de Controle Financeiro Pessoal**, seguindo processos, arquitetura e boas práticas usadas no mercado de trabalho.

O objetivo do projeto é:

* Evoluir desenvolvedores iniciantes/júnior
* Oferecer experiência real com Docker, Git, Pull Requests, Code Review e organização de projeto

---

## 📌 Visão geral do projeto

O CamUp agora é um sistema focado na gestão financeira pessoal, permitindo que cada usuário tenha controle total sobre suas finanças em um ambiente isolado e seguro.

**Funcionalidades base:**

* **Autenticação**: Login e registro seguros por usuário.
* **Dashboard Financeiro**: Acompanhamento de saldo, receitas e despesas em tempo real.
* **Transações**: Registro simples e rápido de entradas e saídas.
* **Categorias**: Organização personalizada (ex: Alimentação, Transporte) com cores.
* **Tema Visual**: Design moderno (Roxo/Branco) com suporte total a **Dark Mode**.

---

## 🧱 Stack utilizada

* **Backend:** PHP 8.2 + Laravel
* **Banco de dados:** MySQL 8
* **Servidor web:** Nginx
* **Ambiente:** Docker + Docker Compose
* **Frontend:** Blade + Tailwind CSS v4 + Alpine.js
* **Controle de versão:** Git + GitHub

---

## ⚠️ Pré-requisitos

Antes de começar, você precisa ter instalado na sua máquina:

* Git
* Docker
* Docker Compose (normalmente já vem com o Docker Desktop)

🔔 **Importante:**

* Não é necessário instalar PHP, MySQL ou Nginx localmente
* Todo o ambiente roda via Docker

---

## 📥 Clonando o projeto

```bash
cd ~
git clone https://github.com/LucasAlbuquerque04/camup-system.git
cd camup-system
```

Estrutura esperada:

```
camup-system/
├── docker/
├── docker-compose.yml
├── setup.sh
├── README.md
└── src/
```

---

## 🐳 Subindo o ambiente (escolha uma opção)

Este projeto oferece **duas formas de setup**:

1️⃣ **Setup automático (recomendado para iniciantes)**
2️⃣ **Setup manual (para quem quer aprender cada etapa)**

Você pode escolher a que fizer mais sentido para você.

---

## � Opção 1 — Setup automático (recomendado)

Essa opção sobe todo o ambiente e configura o Laravel automaticamente.

### ▶️ Passo a passo

Na raiz do projeto, execute:

```bash
chmod +x setup.sh
./setup.sh
```

O script irá:

* Subir os containers Docker
* Instalar dependências (Composer e NPM)
* Gerar a `APP_KEY`
* Rodar as migrations (Banco de dados financeiro)
* Compilar os assets (Tailwind CSS)
* Ajustar permissões necessárias

Ao final, acesse:

```
http://localhost:8010
```

Se tudo deu certo, você verá a tela de Login do CamUp.

---

## 🛠️ Opção 2 — Setup manual (modo aprendizado)

Essa opção é ideal se você **quer entender cada passo** do processo.

### 1️⃣ Subir os containers

Na raiz do projeto:

```bash
docker compose up -d --build
```

Verifique se os containers estão rodando:

```bash
docker ps
```

---

### 2️⃣ Acessar o container da aplicação

```bash
docker compose exec app bash
```

---

### 3️⃣ Configuração inicial do Laravel

#### Copiar o arquivo de ambiente

```bash
cp .env.example .env
```

🔔 **Observação importante:**
Este projeto utiliza **MySQL via Docker**.
Não altere o `DB_CONNECTION` para sqlite.

---

#### Gerar a chave da aplicação

```bash
php artisan key:generate
```

---

#### Rodar as migrations

```bash
php artisan migrate
```

📌 As tabelas de usuários, categorias e transações serão criadas.

---

#### Compilar o Frontend

Em outro terminal (fora do container app), rode o build dos assets:

```bash
docker exec camup_app npm install
docker exec camup_app npm run build
```

---

#### Ajustar permissões (muito importante)

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

---

## 🌐 Acessando o sistema

Abra o navegador e acesse:

```
http://localhost:8010
```

---

## 🧪 Comandos úteis

Parar o ambiente:

```bash
docker compose down
```

Subir novamente:

```bash
docker compose up -d
```

Ver logs:

```bash
docker compose logs -f
```

Acessar o container da aplicação:

```bash
docker compose exec app bash
```

---

## 🔀 Fluxo de trabalho (Git)

Seguimos um fluxo parecido com empresas reais:

* Nunca trabalhar direto na `main`
* Criar uma branch por tarefa:

```bash
git checkout -b feat/nome-da-feature
```

* Commits claros e objetivos:

```bash
git commit -m "feat: adicionar nova categoria"
```

* Push da branch:

```bash
git push origin feat/nome-da-feature
```

* Abrir Pull Request
* Code Review
* Merge na `stage` e depois na `main`

---

## 📚 Observações importantes

* Nunca versionar o arquivo `.env`
* Sempre usar Docker
* Sempre manter o código organizado (Padrão PSR-12)

---

## 🎯 Objetivo educacional

Este projeto não é apenas sobre código.

Ele existe para ensinar:

* Como projetos reais funcionam
* Como trabalhar em equipe
* Como criar sistemas escaláveis e organizados

Se você é iniciante: vá com calma, leia, teste e pergunte.

---

🚀 **Bem-vindo ao CamUp. Aqui a ideia é aprender do jeito certo.**
