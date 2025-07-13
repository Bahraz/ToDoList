<?php
namespace Bahraz\ToDoApp\Controllers;

use Bahraz\ToDoApp\Models\Task;

class AppController
{
    public function viewTask(): void
    {
        $tasks = Task::getAll();
        // Załaduj nagłówek
        require __DIR__ . '/../views/layouts/header.php';

        // Załaduj główny widok strony głównej
        require __DIR__ . '/../views/components/viewTaskComponent.php';

        // Załaduj stopkę
        require __DIR__ . '/../views/layouts/footer.php';
    }

    public function addTask(): void
    {
        require __DIR__ . '/../views/layouts/header.php';

        require __DIR__ . '/../views/components/addTaskComponent.php';
       
        require __DIR__ . '/../views/layouts/footer.php';
    }

    public function about()
    {
        require __DIR__ . '/../views/layouts/header.php';

        require __DIR__ . '/../views/layouts/about.php';

        require __DIR__ . '/../views/layouts/footer.php';
    }

    public function contact(){
        require __DIR__ . '/../views/layouts/header.php';

        require __DIR__ . '/../views/layouts/contact.php';

        require __DIR__ . '/../views/layouts/footer.php';
    }
}
