<x-master-layout>
 
  <x-slot:title>
    {{ $category->name }}
  </x-slot>

  <!-- Featured -->
    <div class="bg-white py-24 sm:py-32">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
          <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ $category->name }}</h2>
        </div>
        <div class="mx-auto mt-16 grid max-w-2xl auto-rows-fr grid-cols-1 gap-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-2">
          @foreach($latest as $article)
            <article class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl bg-gray-900 px-8 pb-8 pt-80 sm:pt-48 lg:pt-80">
              <img src="{{ Storage::url($article->image) }}" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover">
              <div class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
              <div class="absolute inset-0 -z-10 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
      
              <div class="flex flex-wrap items-center gap-y-1 overflow-hidden text-sm leading-6 text-gray-300">
                <time datetime="2020-03-16" class="mr-8">{{ $article->created_at->toFormattedDateString() }}</time>
                <div class="-ml-4 flex items-center gap-x-4">
                  <svg viewBox="0 0 2 2" class="-ml-0.5 h-0.5 w-0.5 flex-none fill-white/50">
                    <circle cx="1" cy="1" r="1" />
                  </svg>
                  <div class="flex gap-x-2.5">
                    <img src="{{ Storage::url($article->author->avatar) }}" alt="" class="h-6 w-6 flex-none rounded-full bg-white/10">
                    <a href="{{ route('home.user', $article->user_id) }}">
                      {{ $article->author->fullName() }}
                    </a>
                  </div>
                </div>
              </div>
              <h3 class="mt-3 text-lg font-semibold leading-6 text-white">
                <a href="{{ route('home.article', $article) }}">
                  <span class="absolute inset-0"></span>
                  {{ $article->title }}
                </a>
              </h3>
            </article>
          @endforeach
        </div>
      </div>
    </div>
    <hr class="mx-auto max-w-7xl pb-10">
    <!-- All -->
    <div class="bg-white pb-24">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
          @foreach($articles as $article)
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
                    <p class="text-gray-600">{{ $article->author->job }}</p>
                  </div>
                </div>
              </div>
            </article>
          @endforeach
        </div>
        <div class="p-10">
          {{ $articles->links() }}
        </div>
      </div>
    </div>
  
  </x-master-layout>