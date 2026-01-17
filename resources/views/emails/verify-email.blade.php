<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .greeting {
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .content {
            color: #666;
            margin-bottom: 30px;
        }
        .verify-button {
            display: inline-block;
            padding: 14px 32px;
            background-color: #4285f4;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            margin: 20px 0;
        }
        .verify-button:hover {
            background-color: #357ae8;
        }
        .alternative-text {
            color: #999;
            font-size: 14px;
            margin-top: 30px;
            margin-bottom: 10px;
        }
        .verification-link {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            word-break: break-all;
            color: #4285f4;
            font-size: 12px;
        }
        .footer {
            margin-top: 40px;
            color: #999;
            font-size: 14px;
        }
        .team-name {
            font-weight: 600;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1 class="greeting">Hello {{ $user->name }},</h1>

        <div class="content">
            <p>Thanks for signing up! Please click the button below to verify your email address.</p>
        </div>

        <a href="{{ $verificationUrl }}" class="verify-button">Verify My Email</a>

        <p class="alternative-text">If the button doesn't work, copy and paste this link into your browser:</p>

        <div class="verification-link">
            {{ $verificationUrl }}
        </div>

        <div class="footer">
            <p>Thanks,<br><span class="team-name">The Lag Artisans Team</span></p>
        </div>
    </div>
</body>
</html>
