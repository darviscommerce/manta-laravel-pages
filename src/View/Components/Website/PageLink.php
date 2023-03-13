<?php

namespace Manta\LaravelPages\View\Components\Website;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Manta\LaravelPages\Models\MantaPage;

class PageLink extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $itemid,
        public ?string $title = null,
        public ?string $link = null,
        public ?string $target = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $item = MantaPage::find($this->itemid);
        $this->link = $item->slug;
        $this->title = $this->title ? $this->title : $item->title;
        $this->target = $this->target ? 'target="_blank"' : null;
        return view('manta-laravel-pages::components.website.link');
    }
}
