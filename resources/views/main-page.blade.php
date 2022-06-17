<x-layout>
    @foreach($news as $news_item)
        <x-news-item :item="$news_item"/>
    @endforeach
</x-layout>

