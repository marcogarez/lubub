<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class SearchAccount extends Component
{
    public $searchQuery;

    public function render()
    {
        $accounts = User::where('username', 'LIKE', $this->searchQuery . '%')->get();
        
        return view('livewire.search-account', [
            'accounts' => $accounts
        ]);
    }
}
