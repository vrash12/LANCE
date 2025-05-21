<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FabellaCares')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU0UFf+OGpamoFVy38MVBnE+IbbVYUew+OrCXaR"
      crossorigin="anonymous"
    >

    <!-- Bootstrap Icons -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css"
      rel="stylesheet"
    >

    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-p8f+Yqf4C6z3sZ4+PsN8/ec8Y5KSJNkxFq0KM+XTRqSBXl0+IRHtdf7qyYNh+1kKEmnA0A6Z1MJP5C9QwbQfKA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    >

    <!-- Optional: your app CSS -->
    @stack('styles')
</head>
<body class="bg-light">

    @yield('content')

    <!-- Bootstrap Bundle JS (with Popper) -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>

    <!-- Optional: your app JS -->
    @stack('scripts')
</body>
</html>
