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
        ]);

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'is_right' => $request->boolean('is_right'),
            'is_left' => $request->boolean('is_left'),
            'active' => $request->boolean('active'),
        ];

        Orisha::create($data);

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
        ]);

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'is_right' => $request->boolean('is_right'),
            'is_left' => $request->boolean('is_left'),
            'active' => $request->boolean('active'),
        ];

        $orisha->update($data);

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
