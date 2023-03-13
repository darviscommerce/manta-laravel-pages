    <div @auth class="tinymce-body" @endauth>
        {!! $content !!}
    </div>
    @if ($tags)
        <div class="tags-wrapper">
            @foreach ($tags as $tag)
                <div class="tag">
                    <div class="tags-content"><img src="images/checkmark.svg" alt="" class="checkmark-icon">
                        <div class="tag-text">{{ $tag }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
