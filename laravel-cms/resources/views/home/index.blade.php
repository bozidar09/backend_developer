<x-master-layout>

  <x-slot:title>
    {{ 'Algebra Blog' }}
  </x-slot>

  <div class="relative pt-14">
    @foreach($categories as $category)
      <!-- Hero section -->
      <div class="bg-white py-24 sm:py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl"><a href="{{ route('home.category', $category) }}">{{ $category->name }}</a></h2>
          </div>
        </div>
      </div>

      <!-- Featured section -->
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="relative overflow-hidden bg-gray-900 px-6 py-20 shadow-xl sm:rounded-3xl sm:px-10 sm:py-24 md:px-12 lg:px-20">
          <img class="absolute inset-0 h-full w-full object-cover brightness-150 saturate-0" src="{{ Storage::url($articles[$category->name]['featured']->image) }}" alt="">
          <div class="absolute inset-0 bg-gray-900/90 mix-blend-multiply"></div>
          <div class="absolute -left-80 -top-56 transform-gpu blur-3xl" aria-hidden="true">
            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-r from-[#ff4694] to-[#776fff] opacity-[0.45]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
          </div>
          <div class="hidden md:absolute md:bottom-16 md:left-[50rem] md:block md:transform-gpu md:blur-3xl" aria-hidden="true">
            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-r from-[#ff4694] to-[#776fff] opacity-25" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
          </div>
          <div class="relative mx-auto max-w-2xl lg:mx-0">
            <p class="text-3xl font-semibold text-white"><a href="{{ route('home.article', $articles[$category->name]['featured']) }}">{{ $articles[$category->name]['featured']->title }}</a></p>
            <figure>
              <blockquote class="mt-6 text-lg line-clamp-5 font-semibold text-white sm:text-xl sm:leading-8">
                <p>{{ $articles[$category->name]['featured']->body }}</p>
              </blockquote>
              <figcaption class="mt-6 text-base text-white">
                <a href="{{ route('home.user', $articles[$category->name]['featured']->user_id) }}">
                  <div class="font-semibold">{{ $articles[$category->name]['featured']->author->fullName() }}</div>
                </a>
                <div class="mt-1">{{ $articles[$category->name]['featured']->author->job }}</div>
              </figcaption>
            </figure>
          </div>
        </div>
      </div>
      
      <!-- Blogs -->
      <div class="bg-white pb-12">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            @foreach($articles[$category->name]['latest'] as $article)
              <article class="flex flex-col items-start justify-between">
                <div class="relative w-full">
                  <img src="{{ Storage::url($article->image) }}" alt="" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                  <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                </div>
                <div class="max-w-xl">
                  <div class="mt-8 flex items-center gap-x-4 text-xs">
                    <time datetime="2020-03-16" class="text-gray-500">{{ $article->created_at->toFormattedDateString() }}</time>
                    <a href="{{ route('home.category', $article->category) }}" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">{{ $article->category->name }}</a>
                  </div>
                  <div class="group relative">
                    <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                      <a href="{{ route('home.article', $article) }}">
                        <span class="absolute inset-0"></span>
                        {{ $article->title }}
                      </a>
                    </h3>
                    <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">{{ $article->body }}</p>
                  </div>
                  <div class="relative mt-8 flex items-center gap-x-4">
                    <img src="{{ Storage::url($article->author->avatar) }}" alt="" class="h-10 w-10 rounded-full bg-gray-100">
                    <div class="text-sm leading-6">
                      <p class="font-semibold text-gray-900">
                        <a href="{{ route('home.user', $article->user_id) }}">
                          <span class="absolute inset-0"></span>
                          {{ $article->author->fullName() }}
                        </a>
                      </p>
                      <p class="text-gray-600">{{ $article->author->role->name }}</p>
                    </div>
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        </div>
      </div>
      <hr class="mx-auto max-w-7xl pb-10">
    @endforeach
  </div>

</x-master-layout>