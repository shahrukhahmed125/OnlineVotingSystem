<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Two-Factor Authentication Code!</title>
</head>
<body style="background-color: #f8f9fa; margin: 0; padding: 20px;">

    <center>
        <a href="{{config('app.url')}}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Gift Icon" style="width: 50px; height: 50px; margin: 17px;">
        </a>
        <table role="presentation" width="100%" style="max-width: 500px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); padding: 20px;">
            <tr>
                <td>
                    <!-- Icon with green background -->
                    {{-- <div style="width: 70px; height: 70px; background-color: #28a745; border-radius: 50%; margin: 0 auto 20px;">
                        <img src="https://cdn-icons-png.flaticon.com/512/16731/16731838.png" alt="Gift Icon" style="width: 35px; height: 35px; margin: 17px;">
                    </div> --}}

                    <!-- Heading -->
                    <h2 style="color: #343a40; margin-bottom: 15px; font-size:">Hello, {{$user->name}}!</h2>

                    <!-- Text -->
                    <p style="color: #6c757d; margin-bottom: 20px;">
                        This email is being sent to you in order to protect your account and to verify your identity on other devices.
                    </p>

                    <p style="color: #6c757d; margin-bottom: 20px;">
                        Your two-factor authentication code is:
                    </p>

                    <!-- Button -->
                    <center>
                        <div style="border: 2px dashed #6c757d; padding: 15px; text-align: center; font-size: 1.2rem; margin-bottom: 20px;">
                            <span style="font-weight: bold; color: #000;">{{$code}}</span>
                            <p style="font-size: 0.9rem; color: #6c757d; margin-top: 5px; margin-bottom: 0;">Expires on {{\Carbon\Carbon::parse($date)->timezone('Asia/Karachi')->format('d/m/Y h:i A')}}</p>
                        </div>
                    </center>

                    <p style="color: #6c757d; margin-bottom: 20px;">
                        This code will expire in 10 minutes.
                    </p>

                    <p style="color: #6c757d; margin-bottom: 20px;">
                        Regards,<br>
                        {{ config('app.name') }}
                    </p>

                    <!-- Line separator -->
                    <hr style="border: 0; border-top: 1px solid #ced4da; margin: 20px 0;">

                    <!-- Signature -->
                    <p style="color: #6c757d; margin-bottom: 20px;">
                        If you're having trouble in this process, then disabled the two factor authentication.
                    </p>
                </td>
            </tr>
        </table>
        <p style="color: #6c757d; margin-bottom: 20px;">
            © {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
        </p>
    </center>

</body>
</html>