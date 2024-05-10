<?php

namespace App\Form;

use App\Entity\Job;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddajobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $jobCategories = [
            "Administration",
            "Agriculture",
            "Arts and Design",
            "Automotive",
            "Aviation",
            "Beauty",
            "Biotechnology",
            "Construction",
            "Consulting",
            "Customer Service",
            "Education",
            "Energy",
            "Engineering",
            "Entertainment",
            "Environmental",
            "Fashion",
            "Finance",
            "Fisheries",
            "Fitness",
            "Food Services",
            "Forestry",
            "Gaming",
            "Government",
            "Healthcare",
            "Hospitality",
            "Human Resources",
            "Information Technology",
            "Insurance",
            "Legal",
            "Logistics",
            "Manufacturing",
            "Maritime",
            "Marketing",
            "Media",
            "Mining",
            "Non-profit",
            "Pharmaceutical",
            "Real Estate",
            "Religious",
            "Research",
            "Retail",
            "Sales",
            "Science",
            "Social Services",
            "Space",
            "Sports",
            "Telecommunications",
            "Transportation",
            "Travel",
            "Utilities"
        ];
        $categoryChoices = ['Select a category' => null];
        foreach ($jobCategories as $category) {
            $categoryChoices[$category] = $category;
        }
        $builder
            ->add('position')
            ->add('employment_type',ChoiceType::class,['choices'=>[
                'Select a type'=>null,
                'Full-time'=>'Full-time',
                'Part-time'=>'Part-time',
                'Internship'=>'Internship']])

            ->add('entreprise')
            ->add('location')
            ->add('category',ChoiceType::class,['choices' => $categoryChoices])
            ->add('description',TextareaType::class, options: [
                'attr' => ['rows' => 6]])
            ->add('submit', SubmitType::class);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
