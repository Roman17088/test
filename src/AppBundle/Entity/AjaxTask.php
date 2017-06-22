<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class AjaxTask
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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $blank = new NotBlank();
        $blank->message = 'empty';
        $metadata->addPropertyConstraint('task', $blank);
        $metadata->addPropertyConstraint('task', new Length([
            'min' => 3,
            'max' => 20,
            'minMessage' => 'Your first name must be at least {{ limit }} characters long',
            'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',
        ]));

        $metadata->addPropertyConstraint('dueDate', new NotBlank());

        $metadata->addPropertyConstraint(
            'dueDate',
            new Type(\DateTime::class)
        );
    }
}