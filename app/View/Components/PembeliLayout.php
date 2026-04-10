<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PembeliLayout extends Component
{
    public function render(): View
    {
        // Arahkan ke file resources/views/layouts/pembeli.blade.php
        return view('layouts.pembeli');
    }
}