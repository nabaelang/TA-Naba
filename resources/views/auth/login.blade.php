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

    <title>Login Page</title>
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
                                        <h4 class="mt-1 mb-5 pb-1">Login to Your Account</h4>
                                    </div>

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email"
                                                class="form-control  @error('email') is-invalid @enderror"
                                                placeholder="Masukkan email" required />
                                            @error('email')
                                                <div id="emailHelp" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password"
                                                class="form-control  @error('password') is-invalid @enderror"
                                                placeholder="Masukkan password" required />
                                            @error('password')
                                                <div id="passwordHelp" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mt-5">
                                            <button type="submit" class="btn btn-md button-primary w-100">
                                                Login
                                            </button>
                                            <p class="text-center mt-3">
                                                Don't have an account?
                                                <a href="/userregister" class="fw-bold"> Sign Up</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2">
                                <img src="{{ asset('custom/image/Image.png') }}" alt="" class="login-image" />
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
