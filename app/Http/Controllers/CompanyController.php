<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        return Inertia::render(
            'Dashboard',
            [
                'companies' => $companies
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): RedirectResponse
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'bail|required|string|max:255|unique:'.Company::class,
            'inn' => 'bail|required|string|max:255|unique:'.Company::class,
            'info' => 'nullable|string',
            'ceo' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);
        Company::create([
            'name' => $request->name,
            'inn' => $request->inn,
            'info' => $request->info,
            'ceo' => $request->ceo,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return Redirect::route('companies.index')->with('message', 'Компания успешно добавлена');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
