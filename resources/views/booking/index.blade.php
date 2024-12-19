@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Booking List') }}</span>
                            <a href="{{ route('booking.create') }}" class="btn btn-sm btn-info">Tambah</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th>No</th>
                                    <th>Nama Acara</th>
                                    <th>Tanggal</th>
                                    <th>Durasi</th>
                                    <th>Pemboking</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $booking->event_name }}</td>
                                            <td>{{ $booking->booking_date->format('Y-m-d') }}</td>
                                            <td>{{ $booking->duration }}</td>
                                            <td>{{ $booking->user->name }}</td>
                                            <td>
                                                @switch($booking->status)
                                                    @case('accepted')
                                                        <span class="badge bg-info text-white">Diterima</span>
                                                    @break
    
                                                    @case('rejected')
                                                        <span class="badge bg-danger text-white">Ditolak</span>
                                                    @break
    
                                                    @case('finished')
                                                        <span class="badge bg-success text-white">Selesai</span>
                                                    @break
    
                                                    @default
                                                        <span class="badge bg-warning text-white">Pending</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="{{ route('booking.show', $booking) }}"
                                                    class="btn btn-sm btn-info">Detail</a>
                                                <a href="{{ route('booking.edit', $booking) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('booking.destroy', $booking) }}" method="post"
                                                    class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
