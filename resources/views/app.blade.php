<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}" type="text/css">
</head>
<body>
	<div id="app"></div>

    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
