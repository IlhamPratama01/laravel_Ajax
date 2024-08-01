<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <article  class="py-8 max-w-screen-md border-gray-300">
        <h2 class="mb-1 text-3xl tracking-tight">{{ $post['judul'] }}</h2>
        <div class="text-base text-gray-500">
                <a  href="#">{{ $post->author->name }}</a> | {{ $post->created_at->diffForHumans() }}
        </div>
        <p class="my-4 font-light">
           {{ $post['body'] }}
        </p>
        <a href="/blog" class="font-medium text-blue-500">Back to post &laquo;;</a>
    </article>
</x-layout>