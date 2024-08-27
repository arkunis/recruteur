<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Types;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['placeholder' => 'Titre de l\'annonce'],
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['placeholder' => 'Description'],
            ])
            ->add('img', FileType::class, [
                "mapped" => false,
                "required" => false,
            ])
            ->add('salary', NumberType::class, [
                'attr' => ['placeholder' => 'Salaire'],
            ])
            ->add('date_publish', DateType::class)
            ->add('duration', IntegerType::class, [
                'attr' => ['placeholder' => 'Durée'],
            ])
            ->add('type', EntityType::class, [
                'class' => Types::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
