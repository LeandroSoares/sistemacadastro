# Sistema de Cadastro

Sistema de gerenciamento de cadastros para casa religiosa de umbanda. Fornece controle de membros, cursos, formações religiosas e informações pessoais.

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=LeandroSoares_sistemacadastro&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=LeandroSoares_sistemacadastro)

## Sobre o Projeto

O Sistema de Cadastro é uma aplicação web desenvolvida com Laravel para gerenciar cadastros de membros de uma casa religiosa de umbanda. O sistema mantém registro detalhado de informações  religiosas, cursos e formações dos membros.

## Funcionalidades

- Cadastro e gerenciamento de usuários com diferentes níveis de permissão
- Gestão de informações religiosas e pessoais
- Registro de formações sacerdotais e cursos
- Controle de orixás de cabeça e iniciados
- Progressão detalhada do perfil dos membros
- Suporte a múltiplos idiomas (pt-BR padrão)
- Controle de uploads para apostilas nos cursos
- Exportação de usuários para formato Excel

## Tecnologias Utilizadas

- Laravel 10.x
- PHP 8.2
- MySQL / SQLite (testes)
- Livewire 3
- TailwindCSS
- AlpineJS
- SonarQube (análise de qualidade)

## Instalação

### Pré-requisitos

- PHP >= 8.2
- Composer
- Node.js e npm
- MySQL (produção) ou SQLite (testes/desenvolvimento)

### Instalação para Desenvolvimento

1. **Clone o repositório**
   ```bash
   git clone https://github.com/LeandroSoares/sistemacadastro.git
   cd sistemacadastro
   ```

2. **Instale as dependências**
   ```bash
   composer install
   npm install
   ```

3. **Configure o ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Edite o arquivo `.env` com:
   - Configurações do banco de dados
   - `ADMIN_PASSWORD=` (senha para o usuário administrador inicial)
   - Outras variáveis específicas do ambiente

4. **Execute as migrations e seeders**
   ```bash
   php artisan migrate --seed
   ```

   > **Nota:** O seeder criará um usuário administrador usando a senha definida no `.env` ou uma senha aleatória segura (mostrada no log em ambiente de desenvolvimento).

5. **Compile os assets**
   ```bash
   npm run dev   # para desenvolvimento com HMR
   npm run build # para produção
   ```

6. **Execute o servidor local**
   ```bash
   php artisan serve
   ```
   
   Acesse o sistema em [http://localhost:8000](http://localhost:8000)

## Testes

Execute os testes com:
```bash
php artisan test
```

Para gerar relatório de cobertura de código:
```bash
XDEBUG_MODE=coverage php artisan test --coverage
```

> **Nota:** A aplicação está configurada para desabilitar o Vite durante os testes automatizados, evitando erros relacionados ao manifesto do Vite.

## Estrutura do Sistema

### Módulos Principais

- **Dados Pessoais:** Gestão de informações básicas dos membros
- **Informações Religiosas:** Registro de dados relacionados à prática religiosa
- **Formação Sacerdotal:** Controle de formação e evolução espiritual
- **Orixás e Entidades:** Cadastro e gerenciamento de orixás de cabeça e iniciados
- **Cursos e Formações:** Registro de cursos e encontros realizados

### Níveis de Usuários

- **Usuário Comum**
  - Visualiza e edita apenas seus próprios dados
  - Acesso limitado às funcionalidades pessoais
  - Sem acesso às informações de outros membros

- **Gerente**
  - Gerencia recursos sob sua responsabilidade
  - Cadastra, edita e remove registros de sua área
  - Visualiza relatórios restritos ao seu escopo
  - Sem acesso às configurações globais

- **Administrador**
  - Controle total do sistema
  - Cria, edita e remove qualquer usuário
  - Acessa todas configurações e relatórios

## Padrões de Desenvolvimento

### Convenções de Commits

O projeto utiliza um template de commit padronizado. Configure-o com:

```bash
git config --local commit.template .gitmessage
```

Estrutura básica dos commits:
```
[tipo]: resumo conciso

Corpo explicativo detalhado (opcional)
```

Tipos comuns: `feat`, `fix`, `docs`, `style`, `refactor`, `test`, `chore`, `ci`.

## Licença

Este projeto está sob licença MIT.
