<x-mail::message>
# Article created

Hello {{ $user->fullName() }}, you created a new article {{ $article->title }}

<x-mail::button :url="route('articles.show', $article)">
See here
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
