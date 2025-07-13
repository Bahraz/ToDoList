<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg"/>
    <meta name="description" content="ToDoList - prosta aplikacja do zarządzania zadaniami" />
    <meta name="keywords" content="ToDoList, zarządzanie zadaniami, aplikacja webowa" />
    <meta name="author" content="Bahraz" />

    <title><?= htmlspecialchars($title ?? 'ToDoList') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body>
<header>
    <div class="container">
      
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="/"><i class="bi bi-clipboard-check"></i> LOGO </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Strona Główna</a>
                        </li>
                        <li class="nav-item">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    ToDoList
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="nav-link" href="/app/AddTask">Dodaj zadanie</a></li>
                                    <li><a class="nav-link" href="/app/ViewTodayTask">Dzisiejsze zadania</a></li>
                                    <li><a class="nav-link" href="/app/ViewAllTask">Wszystkie zadania</a></li>
                                    <li><hr class="dropdown-divider"></li>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/about">O Aplikacji</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/contact">Kontakt</a>
                        </li>
                    </ul>
                </div>
            </nav>
    </div>  
</header>
<main>

<div class="container text-center py-5">
    <h1 class="mb-4">Welcome to To-Do App</h1>
