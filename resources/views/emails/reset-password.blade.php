<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #00ae02; padding: 20px; text-align: center; border-radius: 8px 8px 0 0;">
        <h1 style="color: white; margin: 0;">Password Reset Request</h1>
    </div>

    <div style="background-color: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px;">
        <p>Hello,</p>

        <p>You are receiving this email because we received a password reset request for your account.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $url }}"
               style="background-color: #00ae02; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
                Reset Password
            </a>
        </div>

        <p>This password reset link will expire in {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutes.</p>

        <p>If you did not request a password reset, no further action is required.</p>

        <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">

        <p style="font-size: 12px; color: #666;">
            If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:<br>
            <a href="{{ $url }}" style="color: #00ae02; word-break: break-all;">{{ $url }}</a>
        </p>
    </div>

    <div style="text-align: center; margin-top: 20px; color: #666; font-size: 12px;">
        <p>&copy; {{ date('Y') }} Lagartisans. All rights reserved.</p>
    </div>
</body>
</html>
