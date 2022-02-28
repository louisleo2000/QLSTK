<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FamilyTree extends Component
{
    protected $listeners = ['refreshTree' => '$refresh'];
    public function render()
    {
        $mb = [];
        // count Auth::user()->familyTree
        $count = Auth::user()->familyTree->count();
        if($count >0){
            $mb = Auth::user()->familyTree->first()->members;
        }
       
        $data = array(
          
            'members' => $mb,  
        );
        return view('livewire.family-tree',$data);
    }
}
