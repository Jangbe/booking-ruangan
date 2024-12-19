@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Detail Booking') }}</div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td>Nama Acara</td>
                                <td>:</td>
                                <td>{{ $booking->event_name }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Acara</td>
                                <td>:</td>
                                <td>
                                    {{ $booking->booking_date->format('Y-m-d') }} -
                                    {{ $booking->booking_date->add($booking->duration, 'days')->format('Y-m-d') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
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
                            </tr>
                            <tr>
                                <td>Proposal</td>
                                <td>:</td>
                                <td>
                                    @if (!is_null($booking->proposal) && Storage::exists(substr($booking->proposal, 9)))
                                        <iframe src="{{ $booking->proposal }}" width="100%" height="400px"
                                            frameborder="0"></iframe>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Pemboking</td>
                                <td>:</td>
                                <td>{{ $booking->user->name }}</td>
                            </tr>
                            <tr>
                                <td>Admin ACC</td>
                                <td>:</td>
                                <td>{{ $booking->acceptor?->name }}</td>
                            </tr>
                        </table>
                        @if (auth()->user()->role == 'Admin')
                            <form class="input-group mx-auto" action="{{ route('booking.update-status', $booking) }}"
                                method="POST">
                                @csrf
                                <select name="status" class="form-select">
                                    <option value="accepted" @selected($booking->status == 'accepted')>Terima</option>
                                    <option value="rejected" @selected($booking->status == 'rejected')>Tolak</option>
                                    <option value="finished" @selected($booking->status == 'finished')>Selesai</option>
                                    <option value="pending" @selected($booking->status == 'pending')>Pending</option>
                                </select>
                                <button class="btn btn-success">Submit</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
