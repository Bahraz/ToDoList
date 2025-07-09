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
    <link rel="stylesheet" href="/assets/css/style.css" />
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  </head>
<body>
<header>
    <h1><?= htmlspecialchars($title ?? 'ToDoList') ?></h1>
</header>
<main>
