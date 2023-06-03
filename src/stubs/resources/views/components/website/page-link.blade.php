@if ($item)
    <a href="{{ $link }}" class="{{ $class }}" rel="{{ $rel }}"
        {{ $target }}>{{ $title }}</a>
@else
    ##MISSING-LINK##
@endif
