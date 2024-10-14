<x-modal name="delete-data" focusable>
    <form method="post" action="{{ route($route, $data) }}" class="p-6">
        @csrf
        @method('DELETE')

        <h2 class="text-lg font-medium text-gray-900">Are you sure?</h2>
        <p class="mt-1 text-sm text-gray-600">This will permanently delete your current data</i></p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')" class="me-3">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-link-button type="submit" boja="red">
                {{ __('Delete') }}
            </x-link-button>
        </div>
    </form>
</x-modal>