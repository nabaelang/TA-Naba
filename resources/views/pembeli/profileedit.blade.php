@extends('pembeli.layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <section class="vh-100">
        <div class="container py-5 vh-100">
            <div class="row mb-4">
                <div class="col text-center">
                    <h3 class="display-4">Edit Profile</h3>
                </div>
            </div>
            <div class="row h-100">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $user->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        value="{{ $user->phone_number }}" required>
                                </div>
                                <div class="form-group mb-5">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" required>{{ $user->address }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-md button-primary w-100">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('javascript')
@endpush
