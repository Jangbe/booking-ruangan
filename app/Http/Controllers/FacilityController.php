<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilities = Facility::all();
        return view('facility.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = route('facility.store');
        $method = 'POST';
        $facility  = new Facility();
        return view('facility.form', compact('action', 'method', 'facility'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required',
            'type' => 'required|in:Room,Item',
            'quantity' => 'required|numeric'
        ]);
        Facility::create($valid);
        return to_route('facility.index')->withSuccess('Berhasil menambahkan fasilitas');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        $action = route('facility.update', $facility);
        $method = 'PUT';
        return view('facility.form', compact('action', 'method', 'facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $valid = $request->validate([
            'name' => 'required',
            'type' => 'required|in:Room,Item',
            'quantity' => 'required|numeric'
        ]);
        $facility->update($valid);
        return to_route('facility.index')->withSuccess('Berhasil mengubah fasilitas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();
        return to_route('facility.index')->withSuccess('Berhasil menghapus fasilitas');
    }
}
