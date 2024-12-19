<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::all();
        return view('booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = route('booking.store');
        $method = 'POST';
        $booking  = new Booking();
        $booking->facilities = [new Facility()];
        $facilities = Facility::all()->where('available', '>', 0);
        return view('booking.form', compact('action', 'method', 'booking', 'facilities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'event_name' => 'required',
            'booking_date' => 'required|date',
            'duration' => 'required|numeric',
            'proposal' => 'required|mimes:pdf,doc,docx',
            'facilities.*.facility_id' => 'required|exists:facilities,id',
            'facilities.*.quantity' => 'required|numeric'
        ]);
        $valid['user_id'] = $request->user()->id;
        $valid['proposal'] = '/storage/' . $request->file('proposal')->store('proposals');
        DB::transaction(function () use ($valid) {
            $booking = Booking::create($valid);
            $facilities = [];
            foreach ($valid['facilities'] as $f) {
                $facilities[$f['facility_id']] = ['quantity' => $f['quantity']];
            }
            $booking->facilities()->sync($facilities);
        });
        return to_route('booking.index')->withSuccess('Berhasil menambahkan booking');
    }

    public function show(Booking $booking)
    {
        return view('booking.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $action = route('booking.update', $booking);
        $method = 'PUT';
        $facilities = Facility::all()->where('available', '>', 0);
        return view('booking.form', compact('action', 'method', 'booking', 'facilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $valid = $request->validate([
            'event_name' => 'required',
            'booking_date' => 'required|date',
            'duration' => 'required|numeric',
            'proposal' => 'nullable|mimes:pdf,doc,docx',
            'facilities.*.facility_id' => 'required|exists:facilities,id',
            'facilities.*.quantity' => 'required|numeric'
        ]);
        $valid['user_id'] = $request->user()->id;
        $valid['status'] = 'pending';
        if ($request->hasFile('proposal')) {
            $valid['proposal'] = '/storage/' . $request->file('proposal')->store('proposals');
            if (Storage::exists(substr($booking->proposal, 9))) {
                Storage::delete(substr($booking->proposal, 9));
            }
        }
        DB::transaction(function () use ($booking, $valid) {
            $booking->update($valid);
            $facilities = [];
            foreach ($valid['facilities'] as $f) {
                $facilities[$f['facility_id']] = ['quantity' => $f['quantity']];
            }
            $booking->facilities()->sync($facilities);
        });
        return to_route('booking.index')->withSuccess('Berhasil mengubah booking');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $valid = $request->validate(['status' => 'required|in:accepted,rejected,pending']);
        $valid['accepted_by'] = $request->user()->id;
        $booking->update($valid);
        return to_route('booking.index')->withSuccess('Berhasil mengubah status booking');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        if (Storage::exists(substr($booking->proposal, 9))) {
            Storage::delete(substr($booking->proposal, 9));
        }
        $booking->delete();
        return to_route('booking.index')->withSuccess('Berhasil menghapus booking');
    }
}
