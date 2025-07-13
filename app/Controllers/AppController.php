<?php
namespace Bahraz\ToDoApp\Controllers;

class AppController
{
    public function app(): void
    {
        // Załaduj nagłówek
        require __DIR__ . '/../views/layouts/header.php';

        // Załaduj główny widok strony głównej
        require __DIR__ . '/../views/components/viewTask.php';

        // Załaduj stopkę
        require __DIR__ . '/../views/layouts/footer.php';
    }
}
