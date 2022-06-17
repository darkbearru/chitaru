<x-layout>
    @foreach($news->items as $news_item)
        <x-news-item :item="$news_item"/>
    @endforeach
</x-layout>

