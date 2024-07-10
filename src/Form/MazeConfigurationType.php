<?php

namespace App\Form;

use App\Entity\Maze;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MazeConfigurationType extends AbstractType
{
    private $pointTypeRepository;

    public function __construct(ObjectRepository $pointTypeRepository)
    {
        $this->pointTypeRepository = $pointTypeRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /**
         * @var Maze
         */
        $maze = $options['maze'];

        $choices = $this->getPointTypesAsChoices();

        for ($i = 1; $i <= $maze->getHeight(); $i++) {
            for ($j = 1; $j <= $maze->getWidth(); $j++) {

                $configurationName = 'configuration_' . $i . '_' . $j;

                $builder->add($configurationName, ChoiceType::class, [
                    'mapped' => false,
                    'choices' => $choices,
                    'label' => false,
                ]);
            }
        }

        $builder
            ->add('submit', SubmitType::class)
        ;
    }

    private function getPointTypesAsChoices(): array
    {
        $formattedChoices = [];
        $pointsTypes = $this->pointTypeRepository->findAll();

        foreach ($pointsTypes as $pointType) {
            $formattedChoices[$pointType->getName()] = $pointType->getId();
        }

        return $formattedChoices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('maze')
            ->setDefaults([
            'data_class' => Maze::class,
            'allow_extra_fields' => true,
        ]);
    }
}
