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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

</head>
<body>
<header>
<nav class="navbar navbar-expand-lg navbar-light ">
<div class="container justify-content-between">


    <ul class="navbar-nav mx-auto">
        <li class="nav-item">
            <a class="navbar-brand" href="/">
                <img src="/assets/images/favicon.svg" height="30" alt="Logo">
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    ToDoList
                </button>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="/tasks/form/add">Add task</a></li>
                    <li><a class="nav-link" href="/tasks/view/today">Today tasks</a></li>
                    <li><a class="nav-link" href="/tasks/view/active">Active tasks</a></li>
                    <li><a class="nav-link" href="/tasks/view/completed">Completed tasks</a></li>
                    <li><a class="nav-link" href="/tasks/view/all">All tasks</a></li>
                    <li><a class="nav-link" href="/tasks/view/deleted">Deleted tasks</a></li>
    </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/about">About us</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/contact">Contact</a>
        </li>
    </ul>
</div>
</nav>
</header>
<main>
    <?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="alert alert-success text-center">
        <?= htmlspecialchars($_SESSION['flash_message']); ?>
    </div>
    <?php unset($_SESSION['flash_message']); ?>
<?php endif; ?>
<div class="container text-center py-5">
    <h1 class="mb-4">Welcome to To-Do App</h1>
