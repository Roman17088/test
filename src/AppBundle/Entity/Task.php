<?php

namespace AppBundle\Entity;

class Task
{
    protected $task;
    protected $dueDate;

    public function getTask()
    {
        return $this->task;
    }

    public function setTask($task)
    {
        $this->task = $task;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function setDueDate($dueDate = null)
    {
        $this->dueDate = new \DateTime($dueDate);
    }
}