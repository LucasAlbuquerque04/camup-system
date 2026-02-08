---
description: Deploy do CamUp no Railway.app
---

# 🚀 Deploy do CamUp no Railway

Este workflow ensina como fazer o deploy completo do CamUp no Railway.app, uma plataforma gratuita que suporta Docker e MySQL.

## 📋 Pré-requisitos

- Conta no GitHub (o projeto já deve estar no GitHub)
- Conta no Railway.app (criar em https://railway.app)
- Projeto commitado e com push na branch `main`

---

## 🎯 Passo a Passo

### 1. Criar conta no Railway

1. Acesse https://railway.app
2. Clique em **"Start a New Project"** ou **"Login with GitHub"**
3. Autorize o Railway a acessar seus repositórios do GitHub

---

### 2. Criar novo projeto no Railway

1. No dashboard do Railway, clique em **"New Project"**
2. Selecione **"Deploy from GitHub repo"**
3. Escolha o repositório: **`LucasAlbuquerque04/camup-system`**
4. O Railway vai detectar automaticamente que é um projeto Docker

---

### 3. Adicionar banco de dados MySQL

1. No projeto criado, clique em **"+ New"**
2. Selecione **"Database"** → **"Add MySQL"**
3. O Railway vai criar um banco MySQL automaticamente
4. Anote as credenciais que aparecem (ou use as variáveis de ambiente automáticas)

---

### 4. Configurar variáveis de ambiente

1. Clique no serviço da aplicação (não no banco)
2. Vá em **"Variables"**
3. Adicione as seguintes variáveis:

```env
APP_NAME=CamUp
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-app.railway.app
APP_KEY=base64:SERÁ_GERADO_DEPOIS

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}

SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database

LOG_CHANNEL=stack
LOG_LEVEL=error

MAIL_MAILER=log
```

**Importante:** As variáveis `${{MySQL.XXX}}` são referências automáticas do Railway ao banco MySQL que você criou.

---

### 5. Configurar o Dockerfile de produção

O Railway vai usar o arquivo `railway.dockerfile` (que vamos criar) para fazer o build.

Este arquivo já foi criado automaticamente no projeto.

---

### 6. Criar arquivo railway.json (configuração do Railway)

Este arquivo também já foi criado automaticamente.

---

### 7. Fazer commit e push das alterações

```bash
git add .
git commit -m "chore: adicionar configuração de deploy para Railway"
git push origin main
```

---

### 8. Deploy automático

1. O Railway detecta o push automaticamente
2. Inicia o build usando o `railway.dockerfile`
3. Aguarde o deploy (pode levar 3-5 minutos)
4. Acompanhe os logs em tempo real no dashboard

---

### 9. Gerar APP_KEY (IMPORTANTE)

Após o primeiro deploy:

1. No Railway, vá em **"Settings"** do serviço da aplicação
2. Role até **"Deploy Logs"** ou abra o **Terminal**
3. Execute o comando:

```bash
php artisan key:generate --show
```

4. Copie a chave gerada (ex: `base64:abc123...`)
5. Vá em **"Variables"** e atualize `APP_KEY` com esse valor
6. O Railway vai fazer redeploy automaticamente

---

### 10. Rodar migrations

1. No Railway, abra o **Terminal** do serviço da aplicação
2. Execute:

```bash
php artisan migrate --force
```

3. As tabelas serão criadas no banco MySQL

---

### 11. Acessar a aplicação

1. No Railway, vá em **"Settings"** do serviço
2. Role até **"Domains"**
3. Clique em **"Generate Domain"**
4. O Railway vai gerar uma URL pública (ex: `camup-production.up.railway.app`)
5. Acesse a URL e teste o sistema!

---

## 🔄 Deploys futuros (CI/CD automático)

Após a configuração inicial, todo `git push` na branch `main` vai:

1. ✅ Fazer build automático
2. ✅ Rodar migrations (se configurado)
3. ✅ Fazer deploy da nova versão
4. ✅ Manter zero downtime

---

## 🐛 Troubleshooting

### Erro: "APP_KEY not set"
- Execute `php artisan key:generate --show` no terminal do Railway
- Adicione a chave nas variáveis de ambiente

### Erro: "Connection refused" (banco)
- Verifique se as variáveis `DB_*` estão corretas
- Confirme que o serviço MySQL está rodando

### Erro: "Storage not writable"
- O Dockerfile já configura as permissões corretas
- Se persistir, verifique os logs

### App não carrega CSS/JS
- Execute `npm run build` localmente
- Faça commit dos arquivos em `public/build`
- Push para o GitHub

---

## 💰 Custos

- **Plano gratuito:** $5 de crédito/mês
- **Uso estimado do CamUp:** ~$3-4/mês
- **Suficiente para:** Projeto educacional com tráfego moderado

Se o crédito acabar, o app hiberna (para de rodar). Basta adicionar um cartão ou esperar o próximo mês.

---

## 📚 Recursos úteis

- [Documentação Railway](https://docs.railway.app)
- [Railway Discord](https://discord.gg/railway)
- [Exemplos Laravel no Railway](https://railway.app/templates?q=laravel)

---

🎓 **Pronto! Agora o CamUp está no ar e acessível para qualquer pessoa testar!**
