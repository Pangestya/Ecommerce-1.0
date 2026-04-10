<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PengawasLayout extends Component
{
    public function render(): View
    {
        // Arahkan ke file resources/views/layouts/pengawas.blade.php
        return view('layouts.pengawas');
    }
}