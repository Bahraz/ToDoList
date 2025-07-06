<?php
namespace Bahraz\SettlersWars\Controllers;

use Bahraz\SettlersWars\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/index', ['title' => 'Witamy w SettlersWars!']);
    }
}
