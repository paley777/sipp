<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Http\Requests\StoreRuleRequest;
use App\Http\Requests\UpdateRuleRequest;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.rule.index', [
            'active' => 'Manajemen',
            'rules' => Rule::orderBy('id', 'asc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.rule.create', [
            'active' => 'Manajemen',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRuleRequest $request)
    {
        $validated = $request->validated();
        Rule::create($validated);
        return redirect('/dashboard/rule')->with('success', 'Peraturan telah ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rule $rule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rule $rule)
    {
        return view('dashboard.rule.edit', [
            'active' => 'Manajemen',
            'rule' => $rule,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRuleRequest $request, Rule $rule)
    {
        $validated = $request->validated();
        $rule->update($validated);
        return redirect('/dashboard/rule')->with('success', 'Peraturan telah diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rule $rule)
    {
        Rule::destroy($rule->id);
        return redirect('/dashboard/rule')->with('success', 'Peraturan telah dihapus!');
    }
}
