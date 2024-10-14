<x-app-layout>
    <x-slot:pagebody>
        Articles
    </x-slot>

    <x-slot:header>
        <div class="flex justify-between">
            <h3 class="text-xl">Articles Edit</h3>
            <a></a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <form method="post" action="{{ route('articles.update', $article) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block font-medium text-sm text-gray-700">Article Title</label>
                            <input id="title" name="title" type="text" value="{{ $article->title }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        
                        <div>
                            <label for="body" class="block font-medium text-sm text-gray-700">Article body</label>
                            <textarea id="body" name="body" type="text" rows="12" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">{{ $article->body }}</textarea>
                            <x-input-error :messages="$errors->get('body')" class="mt-2" />
                        </div>

                        <div>
                            <label for="body" class="block font-medium text-sm text-gray-700 mb-2">Article Photo</label>
                            <img class="h-auto max-w-lg rounded-lg" src="{{ Storage::url($article->image) }}" alt="">
                            @unless(Storage::url($article->image))
                                <div class="relative flex gap-3">
                                    <x-link-button type="button" boja="red" x-data="" x-on:click.prevent="$dispatch('open-modal', 'delete-data')">Delete</x-link-button>
                                </div>
                            @endunless
                        </div>

                        <div class="col-span-full">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="image">Upload Article Photo</label>
                            <input id="image" name="image" type="file" accept="image/png, image/jpeg" class="w-full text-gray-500 font-medium text-base bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2.5 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded">
                            <p class="text-xs leading-5 text-gray-600">PNG, JPG up to 10MB</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        @role('admin')
                            <div>
                                <label for="featured" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Featured</label>
                                <select id="featured" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0" {{ old('featured') == 0 ? 'selected' : '' }}>0</option>
                                <option value="1" {{ old('featured') == 1 ? 'selected' : '' }}>1</option>
                                </select>      
                                <x-input-error :messages="$errors->get('featured')" class="mt-2" />
                            </div>
                        @endrole
                      
                        <div class="border-b border-gray-900/10 pb-12">                      
                            <div class="mt-10 space-y-10">
                              <fieldset>
                                <legend class="text-sm font-semibold leading-6 text-gray-900">Choose Category</legend>
                                <div class="mt-6 flex flex-wrap items-center gap-6">
                                    @foreach ($categories as $category)
                                        <x-radio-checkbox id="category-{{ $category->id }}" name="category_id" type="radio" value="{{ $category->id }}" :checked="$article->category_id === $category->id" :label="$category->name" for="category-{{ $category->id }}"/>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                              </fieldset>
                              
                              <fieldset>
                                <legend class="text-sm font-semibold leading-6 text-gray-900">Choose Tags</legend>
                                <div class="mt-6 flex flex-wrap items-center gap-6">
                                    @foreach ($tags as $tag)
                                        <x-radio-checkbox id="tag-{{ $tag->id }}" name="tags[]" type="checkbox" value="{{ $tag->id }}" :checked="$tag->articles->contains($article)" :label="$tag->name" for="tag-{{ $tag->id }}"/>
                                    @endforeach
                                    <div class="relative flex gap-3">
                                        <x-link-button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-tag')">+</x-link-button>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                              </fieldset>
                            </div>
                          </div>

                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('articles.index') }}" class="cursor-pointer rounded-md bg-gray-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>

    @include('components.delete-modal', ['route' => 'articles.destroyImage', 'data' => $article])
    @include('articles.partials.tag-modal')
</x-app-layout>