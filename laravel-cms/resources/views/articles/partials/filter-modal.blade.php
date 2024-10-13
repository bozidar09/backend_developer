<x-modal name="filter-articles" :show="!empty($errors->get('additionalTag')) || $errors->additionalTagCreation->isNotEmpty()" focusable>
    <form method="get" action="{{ route('filter.articles') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900">Filter by</h2>
        <div class="border-b border-gray-900/10 pb-12">                      
            <div class="mt-10 space-y-10">
                <fieldset>
                    <legend class="text-sm font-semibold leading-6 text-gray-900">Choose Users</legend>
                    <div class="mt-6 flex flex-wrap items-center gap-6">
                        @foreach ($data['users'] as $user)
                            <div class="relative flex gap-3">
                                <div class="flex h-6 items-center">
                                    <input id="user-{{ $user->id }}" name="users[]" type="checkbox" value="{{ $user->id }}"
                                    {{ old('user') == $user->id ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="user-{{ $user->id }}" class="font-medium text-gray-900">{{ $user->fullName() }}</label>
                                </div>
                        </div>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                </fieldset>
                <hr>
                <fieldset>
                    <legend class="text-sm font-semibold leading-6 text-gray-900">Choose Categories</legend>
                    <div class="mt-6 flex flex-wrap items-center gap-6">
                        @foreach ($data['categories'] as $category)
                            <div class="relative flex gap-3">
                                <div class="flex h-6 items-center">
                                    <input id="category-{{ $category->id }}" name="categories[]" type="checkbox" value="{{ $category->id }}"
                                    {{ old('category') == $category->id ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="category-{{ $category->id }}" class="font-medium text-gray-900">{{ $category->name }}</label>
                                </div>
                        </div>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </fieldset>
                <hr>    
                <fieldset>
                    <legend class="text-sm font-semibold leading-6 text-gray-900">Choose Tags</legend>
                    <div class="mt-6 flex flex-wrap items-center gap-6">
                        @foreach ($data['tags'] as $tag)
                            <div class="relative flex gap-3">
                                <div class="flex h-6 items-center">
                                    <input id="tag-{{ $tag->id }}" name="tags[]" type="checkbox" value="{{ $tag->id }}"
                                    {{ old('tag') == $tag->id ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="tag-{{ $tag->id }}" class="font-medium text-gray-900">{{ $tag->name }}</label>
                                </div>
                        </div>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('tag_id')" class="mt-2" />
                </fieldset>
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')" class="me-3">
                {{ __('Cancel') }}
            </x-secondary-button>
            <x-algebra.button type="submit">
                {{ __('Filter') }}
            </x-algebra.button>
        </div>
    </form>
</x-modal>