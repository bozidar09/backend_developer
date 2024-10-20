<!doctype html>
<html lang="en">
    <head>
        @include('frontend.layout.head')
        
    </head>
    <body>
        <header class="p-3 text-body-secondary">
            <div class="container">
                @include('frontend.layout.nav')

            </div>
        </header>
        <main>
            <div class="container py-4">
                @include('frontend.layout.message')

                @yield('home')

                <footer class="py-3">
                    @include('frontend.layout.footer')

                </footer>
            </div>
        </main>
        @include('frontend.layout.footer-scripts')

    </body>
</html>