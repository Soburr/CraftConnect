<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Emails</title>
</head>
<body>
    <h2>New Contact Message</h2>
<hr>
    <p><strong>Name:</strong> {{ $name }} </p>
    <p><strong>Email:</strong> {{ $email }} </p>

    <p><strong>Message:</strong></p>
    <p>{{ $userMessage }}</p>

</body>
</html>