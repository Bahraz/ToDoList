<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg"/>
    <meta name="description" content="ToDoList - Manage your tasks efficiently and stay organized." />
    <meta name="keywords" content="ToDoList, Manage tasks, web application" />
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
        <?php if(isset($_SESSION['user_id'])): ?>
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
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link" href="/about">About us</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/contact">Contact</a>
        </li>
        <?php if(!isset($_SESSION['user_id'])): ?>
        <li>
            <a href='/login' class="btn btn-info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                    </svg>
                    Login
            </a>
        </li>
        <?php endif; ?>
        <?php
            if(isset($_SESSION['user_id'])): ?>
                <button class="btn btn-danger" id="logout-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                            <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                    </svg>
                    Logout
                </button>
        <?php endif; ?>
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
    <?php if(!isset($_SESSION['user_id'])): ?>
    <h1 class="mb-4">Welcome to To-Do App</h1>
    <?php endif; if(isset($_SESSION['user_id'])): ?>
    <h1 class="mb-4">Welcome back, <?= htmlspecialchars($_SESSION['user_email']); ?></h1>
    <?php endif; ?>


