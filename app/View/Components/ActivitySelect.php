<?php

namespace App\View\Components;

use App\Models\Activity;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActivitySelect extends Component
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
        $activities = Activity::all();
        return view('admin._partials.activity_select')->with('activities', $activities)->with('selected', $this->selected);
    }
}
