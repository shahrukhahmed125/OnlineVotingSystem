<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>2-Factor Verification.</title>
    <!-- CSS files -->
    <x-css />
</head>

<body class="bg-white">
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">
            <!-- begin pre-loader -->
            <x-pre-loader />
            <!-- end pre-loader -->

            <!--start login contant-->
            <div class="app-contant">
                <div class="bg-white">
                    <div class="container-fluid p-0">
                        <div class="d-flex align-items-center justify-content-center h-100-vh">
                            <div class="login p-50">
                                <h1 class="mb-2">Authenticate Your Account</h1>
                                <p>Please Enter the authorization code sent to
                                <strong>{{ $user_email }}</strong>.</p>
                                <form action="{{ route('2fa.verify', $user_id) }}" method="POST" class="mt-3 mt-sm-5">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="control-label">Code*</label>
                                                <input type="text"
                                                    class="form-control @error('code') is-invalid @enderror" name="code" />
                                                @error('code')
                                                    <p class="invalid-feedback">{{ '*' . $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <button type="submit" class="btn btn-primary text-uppercase">Verify
                                                </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end login contant-->
        </div>
        <!-- end app-wrap -->
    </div>
    <!-- end app -->



    <x-js />
</body>

</html>
