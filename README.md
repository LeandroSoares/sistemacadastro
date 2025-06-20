[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=LeandroSoares_sistemacadastro&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=LeandroSoares_sistemacadastro)

# Sistema de Cadastro

Sistema de gerenciamento de cadastros para casa religiosa de umbanda. Fornece controle de membros, cursos, formações religiosas e informações pessoais.

## Funcionalidades

- Cadastro e gerenciamento de usuários com diferentes níveis de permissão
- Gestão de informações religiosas e pessoais
- Registro de formações sacerdotais e cursos
- Controle de orixás de cabeça e iniciados
- Progressão detalhada do perfil dos membros
- Suporte a múltiplos idiomas (pt-BR padrão)
- Controle de uploads para apostilas nos cursos
- Exportação de usuários para formato Excel

## Instalação

### Pré-requisitos

- PHP >= 8.0
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

   **Nota:** O seeder criará um usuário administrador usando a senha definida no `.env` ou uma senha aleatória segura (mostrada no log em ambiente de desenvolvimento).

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

**Nota:** A aplicação está configurada para desabilitar o Vite durante os testes automatizados, evitando erros relacionados ao manifesto do Vite.

## Estrutura do Sistema

### Módulos Principais

- **Dados Pessoais:** Gestão de informações básicas dos membros
- **Informações Religiosas:** Registro de dados relacionados à prática religiosa
- **Formação Sacerdotal:** Controle de formação e evolução espiritual
- **Orixás e Entidades:** Cadastro e gerenciamento de orixás de cabeça e iniciados
- **Cursos e Formações:** Registro de cursos e encontros realizados

### Níveis de Usuários

#### Usuário Comum
- Visualiza e edita apenas seus próprios dados
- Acesso limitado às funcionalidades pessoais
- Sem acesso às informações de outros membros

#### Gerente
- Gerencia recursos sob sua responsabilidade
- Cadastra, edita e remove registros de sua área
- Visualiza relatórios restritos ao seu escopo
- Sem acesso às configurações globais

#### Administrador
- Controle total do sistema
- Cria, edita e remove qualquer usuário
- Acessa todas configurações e relatórios
- Gerencia permissões, visualiza logs e auditoria

## Boas Práticas e Segurança

- **Controle de Acesso:** Utiliza Spatie Laravel Permission com roles e permissões
- **Proteção de Dados:** Policies protegem o acesso aos recursos
- **Validação Robusta:** Validação de dados no backend para todos componentes Livewire
- **Configuração Segura:** Variáveis sensíveis apenas via `.env`
- **Testes Automatizados:** Cobertura de testes com PHPUnit/Pest (meta: 80%+)
- **CI/CD:** Integração contínua com GitHub Actions e análise SonarQube

## Implantação em Produção

### Via SSH/CLI (Recomendado)

1. **Clone e configure**
   ```bash
   git clone https://github.com/LeandroSoares/sistemacadastro.git
   cd sistemacadastro
   composer install --no-dev --optimize-autoloader
   cp .env.example .env
   # Configure o .env para produção
   php artisan key:generate
   ```

2. **Otimize para produção**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan migrate --force
   ```

3. **Configure o webserver**
   - Aponte o documento root para a pasta `/public`
   - Configure HTTPS com um certificado válido

### Via FTP e phpMyAdmin

1. **Upload dos arquivos**
   - Envie todos arquivos via FTP, incluindo pastas ocultas
   - Configure permissões: `775` para `storage` e `bootstrap/cache`

2. **Configure o banco de dados**
   - Crie um banco MySQL via phpMyAdmin
   - Configure o `.env` com as credenciais corretas
   - Importe a estrutura ou execute migrations via SSH se possível

3. **Gere a chave da aplicação**
   - Se tiver acesso SSH: `php artisan key:generate`
   - Sem SSH: gere a chave localmente e adicione ao `.env`

4. **Segurança**
   - Remova arquivos de instalação e testes do servidor
   - Proteja o `.env` de acessos externos
   - Sempre utilize HTTPS em produção

## Contribuição

1. Fork o repositório
2. Crie sua branch: `git checkout -b feature/nova-funcionalidade`
3. Commit suas alterações: `git commit -m 'Adiciona nova funcionalidade'`
4. Push para a branch: `git push origin feature/nova-funcionalidade`
5. Abra um Pull Request

## Licença

Este projeto está licenciado sob [MIT License](LICENSE).
