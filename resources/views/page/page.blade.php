<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Generator</title>
    <style>
@foreach($css as $file)
{!! file_get_contents($file) !!}
@endforeach
    </style>
</head>
<body>
<noscript><strong>We're sorry but generator doesn't work properly without JavaScript enabled. Please enable it to
        continue.</strong></noscript>
<div id="app"></div>
<script>
@foreach($js as $file)
{!! file_get_contents($file) !!}
@endforeach
</script>
</body>
</html>
