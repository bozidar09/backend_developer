<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class MasterLayout extends Component
{
    public function __construct(
        public ?Collection $categories,
        public ?Collection $tags,
    ) {}
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.master');
    }
}