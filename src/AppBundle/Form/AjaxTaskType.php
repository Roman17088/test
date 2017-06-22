<?php

namespace AppBundle\Form;

use AppBundle\Entity\AjaxTask;
use AppBundle\Form\FieldsType\NewFieldType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AjaxTaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('task', TextType::class, [
                'required' => true,
                'attr' => [
                    'ng-model' => 'user.task',
                ],
            ])
            ->add('dueDate', TextType::class, [
                'attr' => [
                    'ng-model' => 'user.dueDate',
                ],
            ])
            /*->add('newField', NewFieldType::class, [
                'placeholder' => 'Choose a delivery option',
            ])*/
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AjaxTask::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            //'csrf_token_id'   => 'ajax_task_token',
        ]);
    }
}