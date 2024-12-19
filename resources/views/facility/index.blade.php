@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Facility List') }}</span>
                            <a href="{{ route('facility.create') }}" class="btn btn-sm btn-info">Tambah</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table table-striped table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Kuanititas</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($facilities as $facility)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $facility->name }}</td>
                                        <td>{{ $facility->type }}</td>
                                        <td>{{ $facility->quantity }}</td>
                                        <td>
                                            <a href="{{ route('facility.edit', $facility) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('facility.destroy', $facility) }}" method="post"
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
@endsection
