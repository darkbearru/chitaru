<article>
    <header>
        <h3><a href="/{{ $item->type->token }}/{{ $item->id }}">{{ $item->title }}</a></h3>
        <div>
            <div>{{ $item->published_at }}</div>
        </div>
        <p>{{ $item->anons }}</p>
    </header>
</article>
