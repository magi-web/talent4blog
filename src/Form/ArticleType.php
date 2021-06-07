<?php

declare(strict_types=1);

/*
 * This file is part of Talent4tech blog project made by OD&B.
 * Credits Aliptic
 */

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content')
            /*->add('state', ChoiceType::class, [
                'choices' => [
                    'Brouillon' => Article::STATE_DRAFT,
                    'Publié' => Article::STATE_PUBLISHED,
                    'Archivé' => Article::STATE_ARCHIVED,
                ]
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
