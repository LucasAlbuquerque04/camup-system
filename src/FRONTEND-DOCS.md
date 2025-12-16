# Frontend Base - CamUp System

Este documento descreve a estrutura base do frontend do CamUp System, construído com Tailwind CSS v4 e Laravel Blade.

## Estrutura de Diretórios

```
resources/
├── css/
│   └── app.css                 # Estilos globais e configuração do Tailwind
├── js/
│   ├── app.js                  # Ponto de entrada JavaScript com Alpine.js
│   └── bootstrap.js            # Configuração do Axios
└── views/
    ├── layouts/
    │   ├── app.blade.php       # Layout principal da aplicação
    │   └── guest.blade.php     # Layout para páginas de autenticação
    ├── components/
    │   ├── header.blade.php    # Cabeçalho da aplicação
    │   ├── sidebar.blade.php   # Menu lateral
    │   ├── footer.blade.php    # Rodapé
    │   ├── button.blade.php    # Componente de botão reutilizável
    │   ├── card.blade.php      # Componente de card
    │   ├── input.blade.php     # Campo de entrada de formulário
    │   ├── textarea.blade.php  # Campo de texto multi-linha
    │   └── alert.blade.php     # Componente de alerta
    ├── auth/
    │   ├── login.blade.php     # Página de login
    │   ├── register.blade.php  # Página de cadastro
    │   └── forgot-password.blade.php # Página de recuperação de senha
    └── dashboard/
        └── home.blade.php      # Dashboard principal
```

## Componentes

### Layouts

#### app.blade.php
Layout principal da aplicação que inclui:
- Header com navegação
- Sidebar opcional (usa @section('sidebar'))
- Área de conteúdo principal
- Footer
- Sistema de alertas (success/error)

**Uso:**
```blade
@extends('layouts.app')

@section('title', 'Título da Página')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <!-- Seu conteúdo aqui -->
@endsection
```

#### guest.blade.php
Layout para páginas de autenticação (login, register, etc.)

**Uso:**
```blade
@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <!-- Formulário de login -->
@endsection
```

### Componentes Blade

#### Button
Botão reutilizável com variantes de estilo.

**Props:**
- `type`: button (padrão), submit, reset
- `variant`: primary (padrão), secondary, danger, success
- `size`: sm, md (padrão), lg

**Uso:**
```blade
<x-button type="submit" variant="primary" size="md">
    Salvar
</x-button>
```

#### Card
Container estilizado com título e footer opcionais.

**Props:**
- `title`: Título do card (opcional)
- `footer`: Conteúdo do rodapé (opcional)

**Uso:**
```blade
<x-card title="Meu Card">
    Conteúdo do card aqui
</x-card>
```

#### Input
Campo de entrada de formulário com label e validação.

**Props:**
- `label`: Label do campo (opcional)
- `name`: Nome do campo (required)
- `type`: Tipo do input (padrão: text)
- `error`: Mensagem de erro personalizada (opcional)
- `required`: Se o campo é obrigatório (padrão: false)

**Uso:**
```blade
<x-input 
    label="Email"
    name="email"
    type="email"
    placeholder="seu@email.com"
    :required="true"
/>
```

#### Textarea
Campo de texto multi-linha com label e validação.

**Props:**
- `label`: Label do campo (opcional)
- `name`: Nome do campo (required)
- `error`: Mensagem de erro personalizada (opcional)
- `required`: Se o campo é obrigatório (padrão: false)
- `rows`: Número de linhas (padrão: 4)

**Uso:**
```blade
<x-textarea 
    label="Descrição"
    name="description"
    rows="6"
    placeholder="Digite a descrição..."
/>
```

#### Alert
Componente de alerta com diferentes tipos.

**Props:**
- `type`: success, error, warning, info (padrão)
- `dismissible`: Se pode ser fechado (padrão: true)

**Uso:**
```blade
<x-alert type="success">
    Operação realizada com sucesso!
</x-alert>
```

## Tailwind CSS

### Tema Customizado

O arquivo `resources/css/app.css` contém a configuração do tema com:

- **Fonte padrão**: Instrument Sans
- **Cores personalizadas**: Paleta de cores primary (azul)
- **Utilitários customizados**: scrollbar-thin, scrollbar-hide
- **Componentes CSS**: btn, btn-primary, btn-secondary, form-input, form-label

### Classes Utilitárias

Além das classes padrão do Tailwind, foram adicionadas:

```css
.scrollbar-thin      # Scrollbar fina
.scrollbar-hide      # Oculta scrollbar

.btn                 # Estilo base de botão
.btn-primary         # Botão primário (azul)
.btn-secondary       # Botão secundário (cinza)

.form-input          # Estilo de input de formulário
.form-label          # Estilo de label de formulário
```

### Dark Mode

O sistema suporta dark mode automático baseado nas preferências do sistema. Todas as páginas e componentes possuem estilos para modo escuro usando as classes `dark:` do Tailwind.

## JavaScript

### Alpine.js

O Alpine.js está configurado para adicionar interatividade aos componentes. Ele é usado para:

- Dropdowns (menu de usuário no header)
- Mobile menu toggle
- Alertas dismissíveis
- Modals e outros componentes interativos

**Exemplo de uso:**
```html
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open">Conteúdo</div>
</div>
```

## Páginas Disponíveis

### Autenticação
- `/login` - Página de login
- `/register` - Página de cadastro
- `/forgot-password` - Recuperação de senha

### Dashboard
- `/dashboard` - Dashboard principal com:
  - Cards de estatísticas
  - Atividades recentes
  - Ações rápidas
  - Tabela de empresas recentes

## Paleta de Cores

### Cores Padrão
- **Primary**: Azul (#3B82F6)
- **Success**: Verde (#10B981)
- **Danger**: Vermelho (#EF4444)
- **Warning**: Amarelo (#F59E0B)
- **Info**: Azul claro (#3B82F6)

### Cores do Sistema
- **Gray**: Escala de cinza para textos e fundos
- **Backgrounds**: 
  - Light: gray-50 (#F9FAFB)
  - Dark: gray-900 (#111827)

## Como Desenvolver

### Adicionar Novo Componente

1. Crie o arquivo em `resources/views/components/`
2. Use `@props()` para definir propriedades
3. Estilize com classes Tailwind
4. Use no Blade: `<x-nome-do-componente />`

### Adicionar Nova Página

1. Crie o arquivo em `resources/views/` (na pasta apropriada)
2. Estenda o layout: `@extends('layouts.app')` ou `@extends('layouts.guest')`
3. Defina o título: `@section('title', 'Título')`
4. Adicione o conteúdo: `@section('content') ... @endsection`

### Compilar Assets

```bash
# Desenvolvimento (watch mode)
npm run dev

# Produção (minificado)
npm run build
```

## Boas Práticas

1. **Componentes Reutilizáveis**: Crie componentes Blade para elementos que se repetem
2. **Classes Utilitárias**: Use as classes do Tailwind em vez de CSS customizado
3. **Dark Mode**: Sempre adicione estilos `dark:` para modo escuro
4. **Responsividade**: Use os breakpoints do Tailwind (sm:, md:, lg:, xl:)
5. **Acessibilidade**: Use atributos ARIA e labels adequados
6. **Validação**: Sempre valide inputs no servidor e no cliente

## Próximos Passos

Para expandir o frontend, considere:

1. Adicionar mais componentes (modal, dropdown, tabs, etc.)
2. Criar páginas para CRUD de entidades (empresas, usuários, etc.)
3. Implementar gráficos e visualizações de dados
4. Adicionar notificações toast
5. Criar sistema de upload de arquivos
6. Implementar busca e filtros avançados

## Recursos

- [Tailwind CSS v4 Docs](https://tailwindcss.com/docs)
- [Alpine.js Docs](https://alpinejs.dev/)
- [Laravel Blade Docs](https://laravel.com/docs/blade)
