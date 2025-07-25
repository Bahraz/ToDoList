<?php
namespace Bahraz\ToDoApp\Controllers;

class BaseController
{
    protected function render(string $view, array $data = []): void
    {
        extract($data); // udostępnia zmienne w widoku
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/' . $view . '.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }
}
