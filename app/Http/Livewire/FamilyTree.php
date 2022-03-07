<?php

namespace App\Http\Livewire;

use App\Models\Family_tree;
use App\Models\Members;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FamilyTree extends Component
{

    protected $listeners = ['refreshTree' => 'reloaData'];
    public $members = [];
    public $name;
    public function reloaData()
    {
        if (Family_tree::where('user_id', '=', Auth::user()->id)->first() != null) {
            $this->name = Family_tree::where('user_id', '=', Auth::user()->id)->first()->name;
        }

        if (Auth::user()->familyTree->count() > 0) {
            $this->members = Members::where('family_tree_id', '=', Auth::user()->familyTree[0]->id)->get();
        }

        error_log($this->name);
    }
    public function render()
    {
        $this->reloaData();
        return view('livewire.family-tree');
    }
}
