<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Oops!') }}</title>
    <link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dogs.css') }}" type="text/css" rel="stylesheet"> 
    <script>
</script>
</head>
<body>

@include('layouts.partials.navbar')
<h1 align="center">{{ __('Oops!') }}
    <br>
    {{ __('Looks like something went wrong!') }}
</h1>

</section>
</body>
</html>