<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('custom/style/style.css') }}" />

    <title>Sign Up</title>
</head>

<body>
    <section class="vh-100 login">
        <div class="container py-5 vh-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card">
                        <div class="row">
                            <div class="col-lg-6 order-2 order-lg-1">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center">
                                        <img src="{{ asset('custom/image/logo.png') }}" style="width: 160px"
                                            alt="logo" />
                                        <h4 class="mt-1 mb-5 pb-1">Create Your Account</h4>
                                    </div>

                                    <form method="POST" action="{{ route('do.userregister') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Fullname</label>
                                            <input type="text" name="name" id="name"
                                                class="form-control  @error('name') is-invalid @enderror"
                                                placeholder="Masukkan nama" required />
                                            @error('name')
                                                <div id="name" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control  @error('email') is-invalid @enderror"
                                                placeholder="Masukkan email" required />
                                            @error('email')
                                                <div id="email" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" id="password"
                                                class="form-control  @error('password') is-invalid @enderror"
                                                placeholder="Masukkan password" required />
                                            @error('password')
                                                <div id="passwordHelp" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password Confirmation</label>
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation"
                                                class="form-control  @error('password') is-invalid @enderror"
                                                placeholder="Masukkan password" required />
                                            @error('password')
                                                <div id="passwordHelp" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">Phone Number</label>
                                            <input type="text" name="phone_number" id="phone_number"
                                                class="form-control  @error('phone_number') is-invalid @enderror"
                                                placeholder="Masukkan nama" required />
                                            @error('phone_number')
                                                <div id="phone_number" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" rows="3"
                                                required placeholder="Masukkan alamat"></textarea>
                                            @error('address')
                                                <div id="address" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mt-5">
                                            <button type="submit" class="btn btn-md button-primary w-100">
                                                Sign Up
                                            </button>
                                            <p class="text-center mt-3">
                                                Already have an account?
                                                <a href="/login" class="fw-bold"> Sign In</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2">
                                <img src="{{ asset('custom/image/image.png') }}" alt="" class="login-image" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
