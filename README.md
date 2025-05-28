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
   - MySQL

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
   ```
   Edite o arquivo `.env` conforme necessário (DB_HOST, DB_USERNAME, DB_PASSWORD, etc).

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

# Manual dos Níveis de Usuário

## Gerente

- **Acesso:**  
  - Visualiza e gerencia recursos sob sua responsabilidade.
  - Pode cadastrar, editar e remover registros de sua área.
  - Não possui acesso a configurações globais do sistema.

- **Funcionalidades:**  
  - Gerenciamento de equipes/setores.
  - Relatórios restritos ao seu escopo.
  - Aprovação de solicitações dentro do seu nível.

## Admin

- **Acesso:**  
  - Controle total do sistema.
  - Pode criar, editar e remover qualquer usuário, incluindo outros admins e gerentes.
  - Acesso a todas as configurações e relatórios.

- **Funcionalidades:**  
  - Gerenciamento global de permissões e configurações.
  - Visualização de todos os dados do sistema.
  - Auditoria e logs de atividades.

---

## Sobre o Laravel

Este projeto utiliza o framework Laravel. Para mais informações, consulte a [documentação oficial](https://laravel.com/docs).
