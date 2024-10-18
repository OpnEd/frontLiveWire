<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\UserService;

class UserProfile extends Component
{
    public $userProfile;
    protected $userService;

    public function mount(UserService $userService)
    {
        $this->userService = $userService;
        $this->userProfile = $this->userService->getUserProfile();
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
