<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@role('candidate') Candidate Dashboard - @yield('title') @else Voter Dashboard - @yield('title') @endrole</title>
    <x-css/>
    @yield('css')
</head>
<body class="light-sidebar">
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">
            <!-- begin pre-loader -->
            <x-pre-loader/>
            <!-- end pre-loader -->
            <!-- begin app-header -->
            <x-simple-app-header/>
            <!-- end app-header -->
            <!-- begin app-container -->
            <div class="app-container">
                <!-- begin app-main -->
                <div>
                    <!-- begin container-fluid -->
                    @yield('content')
                    <!-- end container-fluid -->
                </div>
                <!-- end app-main -->
            </div>
            <!-- end app-container -->
        </div>
        <!-- end app-wrap -->
    </div>
    <!-- end app -->
    <x-js/>
    @yield('js')
</body>
</html>