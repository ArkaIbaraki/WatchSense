<?php

namespace App\Livewire;

use Livewire\Component;

class GallerySection extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.gallery-section');
    }
}
