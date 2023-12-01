<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Amenity;

class FeatureSelect extends Component
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
        $features = Amenity::where('is_a_feature', 1)->get();
        return view('admin._partials.feature_select')->with('features', $features)->with('selected', $this->selected);
    }
}
