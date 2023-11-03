<?php

namespace App\View\Components;

use App\Models\Amenity;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AminitySelect extends Component
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
        $amenities = Amenity::all();
        return view('admin._partials.aminity_select')->with('amenities', $amenities)->with('selected', $this->selected);
    }
}
