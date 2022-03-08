<?php

namespace App\Http\Livewire;

use App\Models\Members;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalAddMember extends Component
{
    protected $listeners = ['refreshModalmember' => '$refresh','reloadData' => 'reloadData'];
    public $male = [];
    public $female = [];
    public $couples = [];

    public function reloadData()
    {
        // dd($family_tree);
        if (Auth::user()->familyTree->count() > 0) {
            //get members male
            $this->male = Members::where('family_tree_id', '=', Auth::user()->familyTree[0]->id)->where('gender', '=', 'male')->where('couple_id', '!=', null)->get();

            //get member female
            $this->female = Members::where('family_tree_id', '=', Auth::user()->familyTree[0]->id)->where('gender', '=', 'female')->where('couple_id', '!=', null)->get();

            $this->couples = Members::where('family_tree_id', '=', Auth::user()->familyTree[0]->id)->get();
        }
    }
    public function render()
    {
       $this->reloadData();
        return view('livewire.modal-add-member');
    }
}
