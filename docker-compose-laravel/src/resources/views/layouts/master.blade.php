<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    @include('home.partials.head')
  </head>
  <body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-white">
      <header class="absolute inset-x-0 top-0 z-50">
          @include('home.partials.header')
      </header>

      <main class="isolate">
        {{ $slot }}
      </main>

      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <footer aria-labelledby="footer-heading" class="relative border-t border-gray-900/10 py-24">
           @include('home.partials.footer')
        </footer>
      </div>
    </div>
  </body>
</html>