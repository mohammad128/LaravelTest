@extends('layouts.app')
@section('content')

    <x-dashboard>
        @php
        $user = auth()->user();
        @endphp
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">{{ __('Hi ') . $user->name }} </h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-center">
                        <img style="text-center" src="{{ asset('uploads/avatars/' . $user->profile->image) }}"
                            alt="Avatar" class="avatar">


                        <div class="form-group row">

                            <div class="col-md-6">
                                <input class="btn btn-sm" type="file" name="avatar">
                                @error('avatar')
                                    <span style="display:block" class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <br><br>
                    <div class="form-group row">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control-plaintext" readonly
                                value="{{ $user->email }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') ? old('name') : $user->name }}" autocomplete="name"
                                autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="age" class="col-md-4 col-form-label text-md-right">{{ __('Age') }}</label>

                        <div class="col-md-6">
                            <input id="age" type="number" class="form-control @error('age') is-invalid @enderror" name="age"
                                value="{{ old('age') ? old('age') : $user->profile->age }}" autocomplete="age">

                            @error('age')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                        <div class="col-md-6">
                            <input id="address" type="address" class="form-control @error('address') is-invalid @enderror"
                                name="address" value="{{ old('address') ? old('address') : $user->profile->address }}"
                                autocomplete="age" autofocus>

                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                        <div class="col-md-6">
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ old('phone') ? old('phone') : $user->profile->phone }}"
                                autocomplete="age" autofocus>

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bio" class="col-md-4 col-form-label text-md-right">{{ __('Bio') }}</label>

                        <div class="col-md-6">
                            <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" name="bio"
                                autocomplete="bio"
                                autofocus>{{ old('bio') ? old('bio') : $user->profile->bio }}</textarea>
                            @error('bio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </x-dashboard>

@endsection
