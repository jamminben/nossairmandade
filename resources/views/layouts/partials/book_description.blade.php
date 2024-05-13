<div class="col-md-7">
    <div class="entry-meta no-avatar ds content-justify">
        <div class="inline-content big-spacing small-text darklinks book-title">
            <span>
                <strong>{{ $book->getTitle() }}</strong><br>
                <div class="text-right">{{ $book->author }}</div>
            </span>
        </div>
    </div>
    <div class="item-content">
        <p>{!! $book->getDescription() !!}</p>
    </div>
</div>
