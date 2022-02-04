<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <title>Shortener</title>
        <script src="{{ URL::asset('js/app.js') }}"></script>
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}" type="text/css">
    </head>
    <body class="text-center mt-5">
        <h1>Url shortener</h1>
        <br>
        <form id="shortener_url" method="post">
        @csrf
            <input type="text" name="url" id="url" placeholder="Enter url">
            <button type="submit" class="btn btn-primary">Get shorten</button>
        </form>
        <br>
        <h3 id="error"></h3>
        <div class="container">
            <h2>Ваша длинная ссылка:</h2>
            <h3 id="long_url"></h3>
            <br>
            <h2>Ваша короткая ссылка:</h2>
            <h3 id="shorten_url"></h3>
            <button id="to_url" class="btn btn-success">Go to URL</button>
        </div>
    </body>
</html>
