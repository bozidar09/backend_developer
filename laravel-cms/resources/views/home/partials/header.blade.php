<nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
    <div class="flex lg:flex-1">
        <a href="{{ route('home.index') }}" class="-m-1.5 p-1.5">
            <span class="sr-only">Algebra Blog</span>
            <img class="h-12 w-auto" src="{{ Storage::url('images/header/algebra.png') }}" alt="">
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
        @foreach($layoutCategories as $category)
            <x-category-tag href="{{ route('home.category', $category) }}" class="font-semibold text-gray-900">{{ $category->name }}</x-category-tag>
        @endforeach
    </div>
    <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-3">
        <a href="{{ route('login') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Log in</a>
        <a href="{{ route('register') }}" class="rounded-md bg-orange-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign up</a>
    </div>
</nav>
<!-- Mobile menu, show/hide based on menu open state. -->
<div class="lg:hidden" role="dialog" aria-modal="true">
<!-- Background backdrop, show/hide based on slide-over state. -->
<div class="fixed inset-0 z-50"></div>
    <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
        <div class="flex items-center justify-between">
        <a href="#" class="-m-1.5 p-1.5">
            <span class="sr-only">Algebra Blog</span>
            <img class="h-12 w-auto" src="{{ Storage::url('images/header/algebra.png') }}" alt="">
        </a>
        <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
            <span class="sr-only">Close menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        </div>
        <div class="mt-6 flow-root">
        <div class="-my-6 divide-y divide-gray-500/10">
            <div class="space-y-2 py-6">
            @foreach($layoutCategories as $category)
                <a href="{{ route('home.category', $category) }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ $category->name }}</a>
            @endforeach
            </div>
            <div class="py-6">
            <a href="#" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Log in</a>
            </div>
        </div>
        </div>
    </div>
</div>