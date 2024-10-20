<x-modal name="filter-articles" :show="!empty($errors->get('additionalTag')) || $errors->additionalTagCreation->isNotEmpty()" focusable>
    <form method="get" action="{{ route('filter.articles') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900">Filter by</h2>
        <div class="border-b border-gray-900/10 pb-12">                      
            <div class="mt-10 space-y-10">
                <fieldset>
                    <legend class="text-sm font-semibold leading-6 text-gray-900">Choose Authors</legend>
                    <div class="mt-6 flex flex-wrap items-center gap-6">
                        @foreach ($data['users'] as $user)
                            <x-radio-checkbox id="user-{{ $user->id }}" name="users[]" type="checkbox" value="{{ $user->id }}" :checked="old('user') == $user->id" :label="$user->fullName()" for="user-{{ $user->id }}"/>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                </fieldset>
                <hr>
                <fieldset>
                    <legend class="text-sm font-semibold leading-6 text-gray-900">Choose Categories</legend>
                    <div class="mt-6 flex flex-wrap items-center gap-6">
                        @foreach ($data['categories'] as $category)
                            <x-radio-checkbox id="category-{{ $category->id }}" name="categories[]" type="checkbox" value="{{ $category->id }}" :checked="old('category') == $category->id" :label="$category->name" for="category-{{ $category->id }}"/>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </fieldset>
                <hr>    
                <fieldset>
                    <legend class="text-sm font-semibold leading-6 text-gray-900">Choose Tags</legend>
                    <div class="mt-6 flex flex-wrap items-center gap-6">
                        @foreach ($data['tags'] as $tag)
                            <x-radio-checkbox id="tag-{{ $tag->id }}" name="tags[]" type="checkbox" value="{{ $tag->id }}" :checked="old('tag') == $tag->id" :label="$tag->name" for="tag-{{ $tag->id }}"/>
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
            <x-link-button type="submit">
                {{ __('Filter') }}
            </x-link-button>
        </div>
    </form>
</x-modal>