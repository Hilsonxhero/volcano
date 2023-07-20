<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Module Mail</title>
    {{-- <link rel="stylesheet" href="./Resources/assets/sass/app.scss"> --}}

    <style>
        body,
        h1,
        p {
            margin: 0;
            padding: 0;
        }

        body,
        html {
            text-align: right;
            direction: rtl;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            color: #666666;
            line-height: 1.6;
        }

        .code {
            display: inline-block;
            padding: 8px 16px;
            background-color: #f9f9f9;
            border: 1px solid #dddddd;
            border-radius: 4px;
            color: #333333;
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>

    {{-- Laravel Vite - CSS File --}}
    {{-- {{ module_vite('build-mail', 'Resources/assets/sass/app.scss') }} --}}

</head>

<body>
    @yield('content')

    {{-- Laravel Vite - JS File --}}
    {{-- {{ module_vite('build-mail', 'Resources/assets/js/app.js') }} --}}
</body>

</html>
