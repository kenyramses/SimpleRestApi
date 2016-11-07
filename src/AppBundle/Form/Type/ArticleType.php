<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre', TextType::class, [
            'description' => "Titre de l'article"
        ]);

        $builder->add('leadings', TextType::class, [
            'description' => "L'accroche de l'article"
        ]);

        $builder->add('body', TextType::class, [
            'description' => "Le corps de l'article"
        ]);

        $builder->add('createdBy', TextType::class, [
            'description' => "Nom de l'auteur"
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Article',
            'csrf_protection' => false //API CRS_PROTECTION à FALSE
        ]);
    }
}