<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Http\Requests\StoreArchiveRequest;
use App\Http\Requests\UpdateArchiveRequest;
use Illuminate\Support\Str;
use File;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.archive.index', [
            'active' => 'Manajemen',
            'archives' => Archive::orderBy('nama', 'desc')->get(),
        ]);
    }
    /**
     * Display a listing of the resource.
     */
     public function report()
    {
        return view('dashboard.archive.report', [
            'active' => 'Laporan',
            'archives' => Archive::orderBy('nama', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.archive.create', [
            'active' => 'Manajemen',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArchiveRequest $request)
    {
        $validated = $request->validated();
        $file = $request->file('berkas');
        $extension = $file->getClientOriginalExtension();
        $validated['berkas']->move(public_path() . '/archives', $cover = 'archive_' . Str::random(15) . '.' . $extension);
        $validated['berkas'] = 'archives/' . $cover;
        $archive = Archive::create($validated);
        return redirect('/dashboard/archive')->with('success', 'Arsip telah ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Archive $archive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Archive $archive)
    {
        return view('dashboard.archive.edit', [
            'active' => 'Manajemen',
            'archive' => $archive,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArchiveRequest $request, Archive $archive)
    {
        $validated = $request->validated();
        $archive->kode = $validated['kode'];
        $archive->pengunggah = $validated['pengunggah'];
        $archive->nama = $validated['nama'];
        $archive->jenis = $validated['jenis'];
        $archive->kategori = $validated['kategori'];
        $archive->keterangan = $validated['keterangan'];
        if ($request->hasFile('berkas')) {
            // 1. Hapus file lama jika ada
            if ($archive->berkas) {
                File::delete(public_path($archive->berkas));
            }

            // 2. Upload file baru
            $file = $request->file('berkas');
            $extension = $file->getClientOriginalExtension();
            $filename = 'archive_' . Str::random(15) . '.' . $extension;
            $file->move(public_path('archives'), $filename);

            // 3. Ganti path baru
            $archive->berkas = 'archives/' . $filename;
        }
        $archive->save();
        return redirect('/dashboard/archive')->with('success', 'Arsip telah diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Archive $archive)
    {
        if ($archive->berkas) {
            File::delete(public_path($archive->berkas));
        }
        $archive->delete();
        return redirect('/dashboard/archive')->with('success', 'Arsip telah dihapus!');
    }
}
