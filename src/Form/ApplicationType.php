<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\Job;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
        -> add ('motivation', TextareaType::class,[
                'label' => 'Cover Letter',
                'attr' => ['rows' => 5],])
        ->add('cv_path', FileType::class, [
            'label' => 'Upload your cv ',
            'mapped' => false,
            'required' => true,
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
