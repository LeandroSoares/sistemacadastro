# Workflows GitHub Actions

Este diretório contém os workflows de GitHub Actions para CI/CD do projeto:

## laravel-pipeline.yml

**Pipeline principal** que combina em um único workflow:
- Validação do código PHP
- Instalação de dependências
- Execução de testes com cobertura de código
- Análise de qualidade com SonarCloud

Esta é a pipeline principal que deve ser mantida e atualizada.

## dependency-review.yml

Workflow específico para revisão de segurança de dependências de pacotes:
- Analisa dependências em Pull Requests
- Detecta vulnerabilidades conhecidas
- Bloqueia PRs que introduzam pacotes com vulnerabilidades conhecidas

## Configurações relacionadas

- `phpunit.xml`: Configurado com suporte para cobertura de código via XDebug
- `sonar-project.properties`: Configurações para o SonarCloud

## Removidos (Substituídos por laravel-pipeline.yml)

Os seguintes arquivos foram consolidados em `laravel-pipeline.yml` para 
simplificar a manutenção e evitar duplicação:

- `laravel-tests.yml`
- `test-coverage.yml`
- `sonarcloud.yml`
- `ci.yaml`
