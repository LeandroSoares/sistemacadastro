<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Manual de Instalação

1. **Pré-requisitos**  
   - PHP >= 8.0  
   - Composer  
   - Node.js e npm  
   - MySQL (produção) ou SQLite (testes/CI)

2. **Clonar o repositório**
   ```bash
   git clone https://seurepositorio.git
   cd sistema_iweoba
   ```

3. **Instalar dependências**
   ```bash
   composer install
   npm install
   ```

4. **Configurar variáveis de ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Edite o arquivo .env com as configurações do seu ambiente.

5. **Executar migrations**
   ```bash
   php artisan migrate
   ```

6. **Popular o banco de dados (opcional)**
   ```bash
   php artisan db:seed
   ```

7. **Compilar assets**
   ```bash
   npm run dev   # para desenvolvimento
   npm run build # para produção
   ```

8. **Executar servidor local**
   ```bash
   php artisan serve
   ```

# Testes

Execute os testes com:
```bash
php artisan test
```

Para obter relatório de cobertura de código:
```bash
php artisan test --coverage
```

**Nota sobre testes:** A aplicação está configurada para desabilitar o Vite durante os testes automatizados. Isso evita erros relacionados ao manifesto do Vite, já que os testes não necessitam de assets front-end compilados. Esta configuração está implementada no arquivo `tests/TestCase.php`.
   cp .env.example .env
   ```
   Edite o arquivo `.env` conforme necessário (DB_HOST, DB_USERNAME, DB_PASSWORD, etc). Nunca versionar `.env`.

5. **Gerar chave da aplicação**
   ```bash
   php artisan key:generate
   ```

6. **Migrar e popular o banco de dados**
   ```bash
   php artisan migrate --seed
   ```

7. **Iniciar o servidor**
   ```bash
   php artisan serve
   ```

8. **Compilar assets frontend (opcional)**
   ```bash
   npm run dev
   ```

---

# Boas Práticas e Segurança

- Utilize policies para proteger recursos sensíveis.
- Use o pacote Spatie Laravel Permission para controle de acesso.
- Sempre utilize migrations, seeders e factories para manter o banco consistente.
- Configure variáveis sensíveis apenas via `.env`.
- Utilize Livewire para componentes reativos, sempre validando dados no backend.
- Implemente testes automatizados (Pest/PHPUnit) e mantenha boa cobertura.
- Use CI/CD (GitHub Actions) e SonarQube para garantir qualidade e segurança contínua.

# Manual dos Níveis de Usuário

## Gerente
- Visualiza e gerencia recursos sob sua responsabilidade.
- Pode cadastrar, editar e remover registros de sua área.
- Não possui acesso a configurações globais do sistema.
- Gerenciamento de equipes/setores, relatórios restritos ao seu escopo, aprovação de solicitações dentro do seu nível.

## Admin
- Controle total do sistema.
- Pode criar, editar e remover qualquer usuário, incluindo outros admins e gerentes.
- Acesso a todas as configurações e relatórios.
- Gerenciamento global de permissões e configurações, visualização de todos os dados do sistema, auditoria e logs de atividades.

---

## Sobre o Laravel

Este projeto utiliza o framework Laravel. Para mais informações, consulte a [documentação oficial](https://laravel.com/docs).


## Preparação para instalação via FTP e phpMyAdmin

1. **Upload dos arquivos**
   - Faça upload de todos os arquivos e pastas do projeto para o servidor usando um cliente FTP (ex: FileZilla).
   - Certifique-se de enviar inclusive as pastas ocultas (ex: `.env.example`, `.htaccess` se houver).

2. **Permissões de pastas**
   - No servidor, garanta que as pastas `storage` e `bootstrap/cache` tenham permissão de escrita (recomendado: 775 ou 777 apenas se necessário).

3. **Configuração do banco de dados**
   - Crie um banco de dados MySQL via painel de controle ou phpMyAdmin.
   - Importe o arquivo de estrutura do banco (dump `.sql` se disponível) via phpMyAdmin, ou execute as migrations pelo terminal se possível.

4. **Configuração do arquivo `.env`**
   - Renomeie `.env.example` para `.env`.
   - Edite o `.env` com as credenciais do banco de dados, URL do site e outras variáveis sensíveis:
     ```env
     APP_ENV=production
     APP_KEY= # gere uma chave com `php artisan key:generate` e cole aqui
     APP_URL=https://seudominio.com.br
     DB_CONNECTION=mysql
     DB_HOST=localhost
     DB_PORT=3306
     DB_DATABASE=nome_do_banco
     DB_USERNAME=usuario
     DB_PASSWORD=senha
     ```
   - **Nunca** envie o `.env` para repositórios públicos.

5. **Gerar chave da aplicação**
   - Se tiver acesso SSH, execute:
     ```bash
     php artisan key:generate
     ```
   - Se não tiver SSH, gere a chave localmente e cole no `.env` do servidor.

6. **Configuração de cache e otimização**
   - Se possível, rode:
     ```bash
     php artisan config:cache
     php artisan route:cache
     php artisan view:cache
     ```
   - Isso melhora a performance em produção.

7. **Acesso ao sistema**
   - Acesse pelo navegador o domínio configurado.
   - O primeiro usuário admin pode ser criado via seeder ou diretamente no banco, conforme instruções do projeto.

8. **Segurança**
   - Remova arquivos de instalação, dumps e scripts de teste do servidor após a configuração.
   - Mantenha o `.env` protegido e nunca versionado.
   - Sempre utilize HTTPS em produção.
