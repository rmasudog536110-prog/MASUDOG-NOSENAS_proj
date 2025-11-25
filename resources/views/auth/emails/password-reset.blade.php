<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
</head>

<body>
    <h2>Password Reset Request</h2>

    <p>We received a request to reset your password. You can reset your password by clicking the link below:</p>

    <a href="{{ $resetUrl }}">Reset Password</a>

    <p>If you did not request a password reset, no further action is required.</p>

    <p>Thank you, <br> Your Application Team</p>
</body>

</html>