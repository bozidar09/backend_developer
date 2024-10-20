<!doctype html>
<html lang="en">
    <head>
        @include('admin.layout.head')
        
    </head>
    <body>
        <div class="page-wrapper d-flex">
            <aside class="d-flex flex-column p-3 text-bg-dark vh-100-min" style="width: 280px;">              
                @include('admin.layout.sidebar')

            </aside>            
            <div class="content d-flex flex-column flex-grow-1">
                <nav class="p-3 text-bg-dark">                   
                    @include('admin.layout.nav')

                </nav>
                @include('admin.layout.message')

                <main class="container my-3 d-flex flex-column flex-grow-1">
                    @yield('main')

                </main>
                <footer class="py-3 text-bg-dark">
                    @include('admin.layout.footer')

                </footer>
                @include('admin.layout.footer-scripts')

            </div>            
        </div>
    </body>
</html>