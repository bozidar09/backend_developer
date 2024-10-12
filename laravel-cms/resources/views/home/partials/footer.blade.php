<h2 id="footer-heading" class="sr-only">Footer</h2>
<div class="mt-16 grid grid-cols-3 gap-32 xl:col-span-2 xl:mt-0">
  <div class="mt-10 xl:mt-0">
    <h3 class="text-sm font-semibold leading-6 text-gray-900">Subscribe to our newsletter</h3>
    <p class="mt-2 text-sm leading-6 text-gray-600">The latest news, articles, and resources, sent to your inbox weekly.</p>
    <form class="mt-6 sm:flex sm:max-w-md">
      <label for="email-address" class="sr-only">Email address</label>
      <input type="email" name="email-address" id="email-address" autocomplete="email" required class="w-full min-w-0 appearance-none rounded-md border-0 bg-white px-3 py-1.5 text-base text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:w-64 sm:text-sm sm:leading-6 xl:w-full" placeholder="Enter your email">
      <div class="mt-4 sm:ml-4 sm:mt-0 sm:flex-shrink-0">
        <button type="submit" class="flex w-full items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Subscribe</button>
      </div>
    </form>
  </div>
  <div class="pl-10">
    <h3 class="text-sm font-semibold leading-6 text-gray-900">Tags</h3>
    <ul role="list" class="mt-6 space-y-4">
      @foreach($layoutTags as $tag)
        <li>
          <x-category-tag href="{{ route('home.tag', $tag) }}" class="text-gray-600 hover:text-gray-900">{{ $tag->name }}</x-category-tag>
        </li>
      @endforeach
    </ul>
  </div>
  <div  class="pl-10">
    <h3 class="text-sm font-semibold leading-6 text-gray-900">Archives</h3>
    <ul role="list" class="mt-6 space-y-4">
      @foreach($layoutCategories as $category)
        <li>
          <x-category-tag href="{{ route('home.category', $category) }}" class="text-gray-600 hover:text-gray-900">{{ $category->name }}</x-category-tag>
        </li>
      @endforeach
    </ul>
  </div>
</div>