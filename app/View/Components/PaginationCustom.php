<?php

namespace App\View\Components;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class PaginationCustom extends Component
{
    public LengthAwarePaginator $items;

    public function __construct(LengthAwarePaginator $items)
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('components.pagination-custom');
    }
}
