<?php

namespace App\View\Components;

use App\Models\Attraction;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AttractionSelect extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?array $selected=[])
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $attractions = Attraction::all();
        return view('admin._partials.attraction_select')->with('attractions', $attractions)->with('selected', $this->selected);
    }
}
