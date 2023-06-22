<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AtmLayout extends Component
{
    public string $theme;

    public function __construct($bank = 'BRI')
    {
        switch($bank){
            case 'BRI':
                $this->theme = 'bg-blue';
                break;
            case 'BNI':
                $this->theme = 'bg-green';
                break;
            case 'BCA':
                $this->theme = 'bg-red';
                break;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.atm', [
            'theme' => $this->theme,
        ]);
    }
}
