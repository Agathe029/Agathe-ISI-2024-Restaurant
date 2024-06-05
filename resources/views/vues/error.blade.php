<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Assuming you have a CSS file named app.css -->
</head>

<body>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <strong>Error:</strong> {{ $monErreur }}
        </div>
    </div>
</body>

</html>