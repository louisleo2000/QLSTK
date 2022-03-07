<?php

namespace App\Http\Livewire;

use App\Models\Members;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TopNav extends Component
{

    protected $listeners = ['reloadData' => '$refresh'];
   
    public function render()
    {
        return view('livewire.header');
    }
}
