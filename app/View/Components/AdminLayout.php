<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    public function render(): View
    {
        // Arahkan ke file resources/views/layouts/admin.blade.php
        return view('layouts.admin');
    }
}