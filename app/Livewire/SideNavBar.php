<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\UserService;

class SideNavBar extends Component
{
    public $userRole;
    protected $userService;

    public function mount(UserService $userService)
    {
        $this->userService = $userService;
        $userProfile = $this->userService->getUserProfile();
        $this->userRole = $userProfile ? $userProfile['role'] : null; // Asegúrate de que la API devuelva el rol.
    }

    public function render()
    {
        return view('livewire.side-nav-bar', [
            'menuItems' => $this->getMenuItemsByRole($this->userRole),
        ]);
    }

    protected function getMenuItemsByRole($role)
    {
        $menuItems = [
            'admin' => [
                ['name' => 'Dashboard', 'route' => 'dashboard'],
                ['name' => 'Perfil', 'route' => 'profile'],
                /* ['name' => 'Inventarios', 'route' => 'inventories.index'], */
            ],
            'medico' => [
                ['name' => 'Dashboard', 'route' => 'dashboard'],
                ['name' => 'Pacientes', 'route' => 'patients.index'],
                ['name' => 'Agendar Citas', 'route' => 'appointments.create'],
            ],
            'cliente' => [
                ['name' => 'Perfil', 'route' => 'profile.show'],
                ['name' => 'Agendar Citas', 'route' => 'appointments.create'],
                ['name' => 'Mis Citas', 'route' => 'appointments.index'],
            ],
            'guest' => [],
        ];

        return $menuItems[$role] ?? [];
    }
}

