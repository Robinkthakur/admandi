<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $title;
    public $metaDescription;
    public $metaKeywords;
    public $ogImage;
    public $ogType;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $title = null,
        $metaDescription = null,
        $metaKeywords = null,
        $ogImage = null,
        $ogType = null
    ) {
        $this->title = $title;
        $this->metaDescription = $metaDescription;
        $this->metaKeywords = $metaKeywords;
        $this->ogImage = $ogImage;
        $this->ogType = $ogType;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
