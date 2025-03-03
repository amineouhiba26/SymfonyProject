<?php

namespace App\form;

use App\Entity\Image;
use App\Entity\Job;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('company')
            ->add('description')
            ->add('expires_at')
            ->add('email')
            ->add('image', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'type',
            ])
            ->add('valider', SubmitType::class);
    }
}
