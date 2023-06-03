<?php

namespace App\View\Components\Website;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Manta\LaravelPages\Models\MantaPage;

class PageLink extends Component
{

    // <x-website.page-link itemid="31" class="footer-bottom_link" />

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $itemid = null,
        public ?string $title = null,
        public ?string $link = null,
        public ?string $target = null,
        public ?string $class = null,
        public ?string $rel = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $item = MantaPage::find($this->itemid);
        if ($item) {
            $this->link = url("/" . app()->getLocale() . "/" . $item->translation()['get']->slug);
            $this->title = $item->translation()['get']->title;
        }

        return view('components.website.page-link', ['item' => $item]);
    }
}
