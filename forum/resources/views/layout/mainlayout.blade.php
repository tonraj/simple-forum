<!DOCTYPE html>

<html lang="en">

 <head>

   @include('layout.partials.head', ["title" => $title])

 </head>

 <body class="bg-white">

    @include('layout.partials.nav')

    @include('layout.partials.header')

    @yield('content')

    @include('layout.partials.footer')

    @include('layout.partials.footer-scripts')

 </body>

</html>