<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\Job;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        -> add ('motivation',TextType::class)
        ->add('cv_path', FileType::class, [
            'label' => 'Upload your cv ',

            // unmapped means that this field is not associated to any entity property
            'mapped' => false,

            // make it optional so you don't have to re-upload the PDF file
            // every time you edit the Product details
            'required' => false,

            // unmapped fields can't define their validation using attributes
            // in the associated entity, so you can use the PHP constraint classes
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/pdf',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid file',
                ])
            ],
        ])
    ;
       
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
