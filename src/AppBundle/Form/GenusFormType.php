<?php

namespace AppBundle\Form;

use AppBundle\Entity\Genus;
use AppBundle\Entity\SubFamily;
use AppBundle\Entity\User;
use AppBundle\Repository\SubFamilyRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenusFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('speciesCount')
            ->add('funFact')
            ->add('isPublished')
            ->add('subFamily', null, [
                'placeholder' => 'Choose a subfamily',
                'class' => SubFamily::class,
                'query_builder' => function(SubFamilyRepository $repository){
                    return $repository->createAlphabeticalQueryBuilder();
                }
            ])
            ->add('firstDiscoveredAt', null,[
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-datepicker'
                ],
                'html5' => false,
            ])
            ->add('genusScientists', EntityType::class, [
                'class' => User::class,
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Genus::class
        ]);
    }

    public function getName()
    {
        return 'app_bundle_genus_form_type';
    }
}
