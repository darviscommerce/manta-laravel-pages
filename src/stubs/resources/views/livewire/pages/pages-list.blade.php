<div class="container" wire:init="loadTrash">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tekstpagina's</li>
        </ol>
    </nav>
    <div class="mt-3 row">
        <div class="col-4">
            <a href="{{ route('manta.pages.create') }}" class="btn btn-sm btn-success"><i
                    class="fa-solid fa-circle-plus"></i> Toevoegen</a>
        </div>
        <div class="col-4">
        </div>
        <div class="col-4">
            <strong>Zoeken:</strong><br>
            <input wire:model.debounce.300ms="search" type="text" placeholder="Zoeken..."
                class="form-control form-control-sm">
        </div>
    </div>
    <ul class="mt-4 nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $show == 'active' ? 'active' : null }}" aria-current="page"
                wire:click="show('active')">Active</a>
        </li>
        <li class="nav-item {{ $trashed < 1 ? 'd-none' : null }}">
            <a class="nav-link {{ $show == 'active' ? 'trashed' : null }}" href="javascript:;"
                wire:click="show('trashed')"><i class="fa-solid fa-trash-can"></i> <span
                    class="badge rounded-pill text-bg-secondary">{{ $trashed }}</span></a>
        </li>
    </ul>
    <table class="table table-sm table-hover table-striped">
        <thead>
            <tr>
                <th>Titel</th>
                <th width="350">Tools</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>
                        @if ($item->trashed())
                            <button wire:click="restore('{{ $item->id }}')" class="btn btn-sm btn-warning"><i
                                    class="fa-solid fa-rotate-left"></i></button>
                        @elseif ($deleteId == null || $deleteId != $item->id)
                            <a href="{{ route('manta.pages.update', ['input' => $item->id]) }}"
                                class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Aanpassen"><i class="fa-solid fa-pen-to-square"></i></a>

                            @foreach (config('manta-cms.locales') as $key => $value)
                                @if ($key != config('manta-cms.locale'))
                                    @php
                                        $lang = Manta\LaravelPages\Models\MantaPage::where(['locale' => $key, 'pid' => $item->id])->first();
                                    @endphp
                                    <a class="btn btn-sm {{ $lang ? 'btn-warning' : 'btn-success' }}"
                                        href="{{ route('manta.pages.update', ['locale' => $key, 'input' => $item->id]) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Aanpassen"><span
                                            class="{{ $value['css'] }}"></span></a>
                                @endif
                            @endforeach

                            @if ($item->fixed)
                                <a href="javascript:;" class="btn btn-sm btn-danger pe-none" tabindex="-1"
                                    aria-disabled="true" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Is een vast onderdeel"><i class="fa-solid fa-lock"></i></a>
                            @else
                                <button wire:click="delete('{{ $item->id }}')" class="btn btn-sm btn-danger"
                                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verwijderen"><i
                                        class="fa-solid fa-trash-can"></i></button>
                            @endif
                        @elseif($deleteId == $item->id)
                            Verwijder?
                            <button class="btn btn-sm btn-success" wire:click="deleteConfirm"><i
                                    class="fa-solid fa-check"></i></button>
                            <button class="btn btn-sm btn-danger" wire:click="deleteCancel"><i
                                    class="fa-solid fa-xmark"></i></button>
                        @endif
                        @if ($item->slug)
                            <a class="btn btn-sm btn-primary" href="{{ url('/nl/' . $item->slug) }}" target="_blank"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Bekijk in website"><i
                                    class="fa-solid fa-arrow-up-right-from-square"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
            @if (count($items) == 0)
                <tr>
                    <td colspan="5"> Er zijn geen resultaten</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="container">
        <div style="display:table; margin:0 auto;">
            {{ $items->links() }}
        </div>
    </div>
</div>
