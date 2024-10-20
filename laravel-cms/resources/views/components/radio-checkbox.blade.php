@props(['checked', 'for', 'label'])

<div class="relative flex gap-3">
    <div class="flex h-6 items-center">
        <input {{ $attributes }} @checked($checked) class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
    </div>
    <div class="text-sm leading-6">
        <label for="{{ $for }}" class="font-medium text-gray-900">{{ $label }}</label>
    </div>
</div>