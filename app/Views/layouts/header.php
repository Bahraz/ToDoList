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
                                    <div class="btn-group">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Danger
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                                </ul>
                            </div>
            <h1><?= htmlspecialchars($title ?? 'ToDoList') ?></h1>
        
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="/"> LOGO </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Strona Główna</a>
                        </li>
                        <li class="nav-item">

                        </li>
                         <li class="nav-item">
                            <a class="nav-link" href="/home/index">Dodaj zadanie</a>
                        </li>  
                        <li class="nav-item">
                            <a class="nav-link" href="/home/index">Dzisiejsze zadania</a>
                        </li>           
                        <li class="nav-item">
                            <a class="nav-link" href="/about">Wszystkie zadania</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/contact">O Aplikacji</a>
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
