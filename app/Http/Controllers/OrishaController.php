<?php

namespace App\Http\Controllers;

use App\Models\Orisha;
use Illuminate\Http\Request;

class OrishaController extends Controller
{
    private const VALIDATION_RULES = [
        'name' => 'required|max:255',
        'description' => 'required',
        'is_right' => 'required|boolean',
        'is_left' => 'required|boolean',
        'active' => 'required|boolean'
    ];

    private const SUCCESS_MESSAGES = [
        'store' => 'Orixá criado com sucesso.',
        'update' => 'Orixá atualizado com sucesso.',
        'destroy' => 'Orixá excluído com sucesso.'
    ];

    public function index()
    {
        $orishas = Orisha::all();
        return view('orishas.index', compact('orishas'));
    }

    public function create()
    {
        return view('orishas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);

        Orisha::create($validated);

        return redirect()->route('orishas.index')
            ->with('success', self::SUCCESS_MESSAGES['store']);
    }

    public function edit(Orisha $orisha)
    {
        return view('orishas.edit', compact('orisha'));
    }

    public function update(Request $request, Orisha $orisha)
    {
        $validated = $request->validate(self::VALIDATION_RULES);

        $orisha->update($validated);

        return redirect()->route('orishas.index')
            ->with('success', self::SUCCESS_MESSAGES['update']);
    }

    public function destroy(Orisha $orisha)
    {
        $orisha->delete();

        return redirect()->route('orishas.index')
            ->with('success', self::SUCCESS_MESSAGES['destroy']);
    }
}
