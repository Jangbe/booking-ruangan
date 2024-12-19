@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Form Facility') }}</div>

                    <div class="card-body">

                        <form action="{{ $action }}" method="post">
                            @csrf @method($method)

                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Facility Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name', $facility->name) }}" required
                                        autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="type"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Type') }}</label>

                                <div class="col-md-6">
                                    <select id="type" class="form-control @error('type') is-invalid @enderror"
                                        name="type">
                                        <option value="Room" @selected(old('type', $facility->type) == 'Room')>Ruangan</option>
                                        <option value="Item" @selected(old('type', $facility->type) == 'Item')>Barang</option>
                                    </select>

                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="quantity"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Facility quantity') }}</label>

                                <div class="col-md-6">
                                    <input id="quantity" class="form-control @error('quantity') is-invalid @enderror"
                                        name="quantity" type="number" value="{{ old('quantity', $facility->quantity) }}"
                                        required>

                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
