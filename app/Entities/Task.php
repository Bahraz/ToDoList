<?php

namespace Bahraz\ToDoApp\Entities;

class Task{

    private ?int $id;
    private ?int $userId;
    private string $title;
    private bool $completed;
    private string $priority;
    private string $date;
    private bool $deleted;

    public function __construct(?int $id, ?int $userId=0, string $title='', bool $completed=false, string $priority='',string $date='',bool $deleted=false)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->completed = $completed;
        $this->priority = $priority;
        $this->date = $date;
        $this->deleted = $deleted;
    }

    public function getId(): ?int {return $this->id;}
    public function getUserId(): int {return $this->userId;}
    public function getTitle(): string {return $this->title;}
    public function getCompleted(): bool {return $this->completed;}
    public function getPriority(): string {return $this->priority;}
    public function getDate(): string {return $this->date;}
    public function getDeleted(): bool {return $this->deleted;}

    public function setId(?int $id): void {$this->id = $id;}
    public function setUserId(?int $userId): void {$this->userId = $userId;}
    public function setTitle(string $title): void {$this->title = $title;}
    public function setCompleted(bool $completed): void {$this->completed = $completed;}
    public function setPriority(string $priority): void {$this->priority = $priority;}
    public function setDate(string $date): void {$this->date = $date;}
    public function setDeleted(bool $deleted): void {$this->deleted = $deleted;}
}