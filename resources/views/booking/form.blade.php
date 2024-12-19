@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Form Booking') }}</div>

                    <div class="card-body">

                        <form action="{{ $action }}" method="post" enctype="multipart/form-data">
                            @csrf @method($method)

                            <div class="row mb-3">
                                <label for="event_name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Event Name') }}</label>

                                <div class="col-md-6">
                                    <input id="event_name" class="form-control @error('event_name') is-invalid @enderror"
                                        name="event_name" value="{{ old('event_name', $booking->event_name) }}" required
                                        autocomplete="event_name" autofocus>

                                    @error('event_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="booking_date"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Booking Date') }} /
                                    {{ __('Duration') }}</label>

                                <div class="col-md-3 col-6">
                                    <input id="booking_date"
                                        class="form-control @error('booking_date') is-invalid @enderror" name="booking_date"
                                        type="date"
                                        value="{{ old('booking_date', $booking->booking_date?->format('Y-m-d')) }}" required
                                        autocomplete="booking_date">

                                    @error('booking_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-6">
                                    <input id="duration" class="form-control @error('duration') is-invalid @enderror"
                                        name="duration" type="number" value="{{ old('duration', $booking->duration) }}"
                                        required autocomplete="duration">

                                    @error('duration')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="proposal"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Proposal File') }}</label>

                                <div class="col-md-6">
                                    <input id="proposal" class="form-control @error('proposal') is-invalid @enderror"
                                        name="proposal" type="file" value="{{ old('proposal', $booking->proposal) }}"
                                        autocomplete="proposal" accept=".pdf, .docx, .doc" @required($method == 'POST')>

                                    @error('proposal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            @if (!is_null($booking->proposal) && Storage::exists(substr($booking->proposal, 9)))
                                <iframe src="{{ $booking->proposal }}" width="100%" height="400px"
                                    frameborder="0"></iframe>
                            @endif

                            <h3>Fasilitas</h3>
                            <div class="facilities">
                                @foreach (old('facilities', $booking->facilities) as $i => $bf)
                                    <div class="row g-2 mb-2">
                                        <label for="facility" class="col-md-4 col-form-label text-md-end">
                                            Fasilitas / Quantity
                                        </label>
                                        <div class="col-md-4 col-7">
                                            <select name="facilities[{{ $i }}][facility_id]"
                                                class="form-control @error('facilities.' . $i . '.facility_id') is-invalid @enderror">
                                                <option>----Pilih----</option>
                                                @foreach ($facilities as $facility)
                                                    <option value="{{ $facility->id }}" @selected($bf['id'] == $facility->id)
                                                        data-facility="{{ $facility }}">
                                                        {{ $facility->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-5">
                                            <div class="input-group">
                                                <input
                                                    class="form-control @error('facilities.' . $i . '.quantity') is-invalid @enderror"
                                                    name="facilities[{{ $i }}][quantity]" type="number"
                                                    max="{{ $facilities->where('id', $bf->id)->first()?->available }}"
                                                    value="{{ $bf->pivot?->quantity }}" required>
                                                <button type="button"
                                                    class="btn btn-sm btn-success add-facility">+</button>
                                                <button type="button" @disabled($i == 0)
                                                    class="btn btn-sm btn-danger remove-facility">-</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" @disabled(in_array($booking->status, ['accepted', 'finished']))>
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

    <script>
        let length = $('.facilities').children().length;
        $(document).on('change', '.facilities select', function() {
            const facility = $(this).find('option:selected').data('facility');
            if (facility) $(this).parent().next().find('input').attr('max', facility.available)
        })
        $(document).on('click', '.add-facility', function() {
            $(this).parent().parent().parent().after(`<div class="row g-2 mb-2">
                <label for="facility" class="col-md-4 col-form-label text-md-end">
                    Fasilitas / Quantity
                </label>
                <div class="col-md-4">
                    <select name="facilities[${length}][facility_id]"
                        class="form-control">
                        <option>----Pilih----</option>
                        @foreach ($facilities as $facility)
                            <option value="{{ $facility->id }}" data-facility="{{ $facility }}">{{ $facility->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <input
                            class="form-control" type="number"
                            name="facilities[${length}][quantity]" required>
                        <button type="button"
                            class="btn btn-sm btn-success add-facility">+</button>
                        <button type="button"
                            class="btn btn-sm btn-danger remove-facility">-</button>
                    </div>
                </div>
            </div>`);
            length++;
        })
        $(document).on('click', '.remove-facility', function() {
            $(this).parent().parent().parent().remove()
        })
    </script>
@endsection
