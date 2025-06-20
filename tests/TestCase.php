<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setup antes de cada teste
     *
     * Esta configuração desativa o Vite durante os testes para evitar o erro:
     * "Vite manifest not found at: path/to/public/build/manifest.json"
     *
     * Como os testes não precisam carregar assets reais, apenas verificar funcionalidades,
     * podemos desabilitar o Vite para evitar a necessidade de compilar os assets antes dos testes.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Desabilita o Vite para os testes
        $this->withoutVite();
    }
}
