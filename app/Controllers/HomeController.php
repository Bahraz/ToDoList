<?php
namespace Bahraz\ToDoApp\Controllers;

class HomeController
{
    public function index(): void
    {
        // Załaduj nagłówek
        require __DIR__ . '/../views/layouts/header.php';

        // Załaduj główny widok strony głównej
        require __DIR__ . '/../views/home/index.php';

        // Załaduj stopkę
        require __DIR__ . '/../views/layouts/footer.php';
    }
}
