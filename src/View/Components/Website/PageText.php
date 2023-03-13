<?php

namespace Manta\LaravelPages\View\Components\Website;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Manta\LaravelPages\Models\MantaPage;

class PageText extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $itemid,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $item = MantaPage::find($this->itemid);
        $content = $item->content;
        return view('manta-laravel-pages::components.website.text', compact('content'));
    }
}
