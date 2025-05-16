<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrUpdateGuruRequest;
use App\Models\Guru;
use App\Models\User;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gurus = Guru::with('user')->latest()->paginate(10);
        return view('guru.index', compact('gurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::doesntHave('guru')->get();
        return view('guru.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrUpdateGuruRequest $request)
    {
        Guru::create($request->validated());
        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        $users = User::all();
        return view('guru.edit', compact('guru', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrUpdateGuruRequest $request, Guru $guru)
    {
        $guru->update($request->validated());
        return redirect()->route('guru.index')->with('success', 'Guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}
