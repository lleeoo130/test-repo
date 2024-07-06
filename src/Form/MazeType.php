<?php

namespace App\Form;

use App\Entity\Maze;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MazeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('width', ChoiceType::class, ['choices' => [
                8 => 8,
                16 => 16,
                24 => 24,
            ]])
            ->add('height', ChoiceType::class, ['choices' => [
                8 => 8,
                16 => 16,
                24 => 24,
            ]])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Maze::class,
        ]);
    }
}
