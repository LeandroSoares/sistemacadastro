<?php

namespace App\Http\Controllers;

use App\Models\Orisha;
use Illuminate\Http\Request;

class OrishaController extends Controller
{
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
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'is_right' => 'required|boolean',
            'is_left' => 'required|boolean',
            'active' => 'required|boolean'
        ]);

        Orisha::create($validated);

        return redirect()->route('orishas.index')
            ->with('success', 'Orixá criado com sucesso.');
    }

    public function edit(Orisha $orisha)
    {
        return view('orishas.edit', compact('orisha'));
    }

    public function update(Request $request, Orisha $orisha)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'is_right' => 'required|boolean',
            'is_left' => 'required|boolean',
            'active' => 'required|boolean'
        ]);

        $orisha->update($validated);

        return redirect()->route('orishas.index')
            ->with('success', 'Orixá atualizado com sucesso.');
    }

    public function destroy(Orisha $orisha)
    {
        $orisha->delete();

        return redirect()->route('orishas.index')
            ->with('success', 'Orixá excluído com sucesso.');
    }
}
