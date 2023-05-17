<div class="container">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('manta.pages.list') }}">Tekstpagina's</a></li>
            <li class="breadcrumb-item active" aria-current="page"><em>{!! $item->translation()['get']->title !!}</em> uploads</li>
        </ol>
    </nav>
    @if (count(config('manta-cms.locales')) > 1)
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ !isset($plugin) && config('manta-cms.locale') == $locale ? 'active' : null }}" aria-current="page"
                href="{{ route('manta.pages.update', ['input' => $item->translation()['org']->id]) }}">{{ config('manta-cms.locales')[config('manta-cms.locale')]['language'] }} <span
                    class="{{ config('manta-cms.locales')[config('manta-cms.locale')]['css'] }}"></span></a>
        </li>
        @foreach (config('manta-cms.locales') as $key => $value)
            @if ($key != config('manta-cms.locale'))
                <li class="nav-item">
                    <a class="nav-link {{ $key == $locale ? 'active' : null }}"
                        href="{{ route('manta.pages.update', ['locale' => $key, 'input' => $item->id]) }}">{{ $value['language'] }}
                        <span class="{{ $value['css'] }}"></span></a>
                </li>
            @endif
        @endforeach
        <li class="nav-item">
            <a class="nav-link {{ isset($plugin) && $plugin == 'uploads' ? 'active' : null }}"
                href="{{ route('manta.pages.uploads', ['locale' => $key, 'input' => $item->id]) }}">Uploads</a>
        </li>
    </ul>
@endif
    @livewire('uploads-upload')
</div>
