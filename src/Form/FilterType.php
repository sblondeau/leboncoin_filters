<?php

namespace App\Form;

use App\DTO\SearchDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('minPrice', MoneyType::class, [
                'required' => false,
                'label' => 'Minimum',
                'currency' => false,
            ])
            ->add('maxPrice', MoneyType::class, [
                'required' => false,
                'label' => 'Maximum',
                'currency' => false,
                ])
            ->add('isUrgent', CheckboxType::class, [
                'required' => false,
                'label' => 'Annonces urgentes uniquement',
            ])       
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchDto::class,
        ]);
    }
}
