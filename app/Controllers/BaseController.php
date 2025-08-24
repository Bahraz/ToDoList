<?php
namespace Bahraz\ToDoApp\Controllers;
class BaseController
{
    protected function render(string $view, array $data = []): void
    {
        extract($data); 
        require __DIR__ . '/../Views/Layouts/header.php';
        require __DIR__ . '/../Views/' . $view . '.php';
        require __DIR__ . '/../Views/Layouts/footer.php';
    }
    
    protected function respond($data, int $statusCode = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    protected function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function redirectIfAuthenticated(array $paths = ['/login', '/register']): void
    {
        $this->startSession();

        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if(isset($_SESSION['user_id']) && in_array($currentPath, $paths, true)) {
            header('Location: /tasks/view/active');
            exit();
        }
    }
}
