<!DOCTYPE html>
<html lang="en">


<head>
    <title> Register - Online Voting System</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Admin template that can be used to build dashboards for CRM, CMS, etc." />
    <meta name="author" content="Potenza Global Solutions" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <x-css/>
</head>

<body class="bg-white">
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">
            <!-- begin pre-loader -->
            <x-pre-loader/>
            <!-- end pre-loader -->

            <!--start login contant-->
            <div class="app-contant">
                <div class="bg-white">
                    <div class="container-fluid p-0">
                        <div class="row no-gutters">
                            <div class="col-sm-6 col-lg-5 col-xxl-3  align-self-center order-2 order-sm-1">
                                <div class="d-flex align-items-center h-100-vh">
                                    <div class="register p-5">
                                        <h1 class="mb-2">Welcome to E-Voting</h1>
                                        <p>Welcome, Please create your account.</p>
                                        <form action="{{route('register_auth')}}" method="POST" class="mt-2 mt-sm-5">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Registered CNIC*</label>
                                                        <input type="text" class="form-control @error('cnic') is-invalid @enderror inputmask" placeholder="xxxx-xxxxxxx-x" data-mask="99999-9999999-9" pattern="\d{5}-\d{7}-\d{1}"  title="Enter CNIC in format 12345-1234567-1" name="cnic" required id="cnic"/>
                                                        @error('cnic')
                                                            <p class="invalid-feedback">{{'*'.$message}}</p>
                                                        @enderror        
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Password*</label>
                                                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required/>
                                                        @error('password')
                                                            <p class="invalid-feedback">{{'*'.$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Confirm Password*</label>
                                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" name="password_confirmation" required/>
                                                        @error('password_confirmation')
                                                            <p class="invalid-feedback">{{'*'.$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="gridCheck" required>
                                                        <label class="form-check-label" for="gridCheck">
                                                            I accept terms & policy
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <button type="submit" class="btn btn-primary text-uppercase">Sign up</button>
                                                </div>
                                                <div class="col-12  mt-3">
                                                    <p>Already have an account ?<a href="{{route('login')}}"> Sign In</a></p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-9 col-lg-7 bg-gradient o-hidden order-1 order-sm-2">
                                <div class="row align-items-center h-100">
                                    <div class="col-7 mx-auto ">
                                        <img class="img-fluid" src="assets/img/bg/login.svg" alt="">
                                    </div>
                                </div>
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



    <x-js/>
</body>


</html>