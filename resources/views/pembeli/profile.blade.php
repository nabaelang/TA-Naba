@extends('pembeli.layouts.app')

@section('title', 'Profile')

@section('content')
    <section class="vh-100">
        <div class="container py-5 vh-100">
            <div class="row mb-4">
                <div class="col text-center">
                    <h3 class="display-4">Profile</h3>
                </div>
            </div>
            <div class="row h-100">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <img src="{{ asset('custom/image/logo.png') }}" alt="Profile Picture" class="rounded-circle"
                                    width="150">
                                <h4 class="mt-2">{{ $user->name }}</h4>
                            </div>
                            <div class="row justify-content-center">
                                <div class="text-center">
                                    <p><strong>Email:</strong> {{ $user->email }}</p>
                                    <p><strong>Phone Number:</strong> {{ $user->phone_number }}</p>
                                    <p><strong>Address:</strong> {{ $user->address }}</p>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="btn btn-md button-primary mt-4 w-100">Edit
                                Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('javascript')
@endpush
