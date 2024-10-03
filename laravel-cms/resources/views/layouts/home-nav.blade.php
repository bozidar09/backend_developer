<div class="flex lg:flex-1">
    <a href="#" class="-m-1.5 p-1.5">
        <span class="sr-only">Algebra Blog</span>
        <img class="h-8 w-auto" src="https://tailwindcss.com/_next/static/media/tailwindcss-mark.3c5441fc7a190fb1800d4a5c7f07ba4b1345a9c8.svg" alt="">
    </a>
</div>
<div class="flex lg:hidden">
    <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
        <span class="sr-only">Open main menu</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>
    </div>
    <div class="hidden lg:flex lg:gap-x-12">
        @foreach($categories as $category)
            <a href="#" class="text-sm font-semibold leading-6 text-gray-900">{{ $category->name }}</a>
        @endforeach
    </div>
    <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-3">
    <a href="{{ route('login') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Log in</a>
    <a href="{{ route('register') }}" class="rounded-md bg-orange-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign up</a>
</div>