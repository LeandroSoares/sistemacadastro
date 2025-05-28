<?php

namespace App\Http\Controllers;

use App\Models\Orisha;
use Illuminate\Http\Request;

class OrishaController extends Controller
{
    private const VALIDATION_RULES = [
        'name' => 'required|max:255',
        'description' => 'required',
        'is_right' => 'nullable',
        'is_left' => 'nullable',
        'active' => 'nullable'
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
        try {
            $validated = $request->validate(self::VALIDATION_RULES);

            $data = [
                'name' => $validated['name'],
                'description' => $validated['description'],
                'is_right' => $request->has('is_right'),
                'is_left' => $request->has('is_left'),
                'active' => $request->boolean('active', true)
            ];

            \Log::info('Creating Orisha with data:', $data);

            $orisha = Orisha::create($data);

            if (!$orisha) {
                \Log::error('Failed to create Orisha');
                return back()->with('error', 'Erro ao criar Orixá.');
            }

            return redirect()->route('orishas.index')
                ->with('success', self::SUCCESS_MESSAGES['store']);
        } catch (\Exception $e) {
            \Log::error('Error creating Orisha: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erro ao criar Orixá: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Orisha $orisha)
    {
        return view('orishas.edit', compact('orisha'));
    }

    public function update(Request $request, Orisha $orisha)
    {
        try {
            $validated = $request->validate(self::VALIDATION_RULES);

            $data = [
                'name' => $validated['name'],
                'description' => $validated['description'],
                'is_right' => $request->has('is_right'),
                'is_left' => $request->has('is_left'),
                'active' => $request->has('active')
            ];

            \Log::info('Updating Orisha with data:', $data);

            $orisha->update($data);

            return redirect()->route('orishas.index')
                ->with('success', self::SUCCESS_MESSAGES['update']);
        } catch (\Exception $e) {
            \Log::error('Error updating Orisha: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erro ao atualizar Orixá: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Orisha $orisha)
    {
        $orisha->delete();

        return redirect()->route('orishas.index')
            ->with('success', self::SUCCESS_MESSAGES['destroy']);
    }
}
