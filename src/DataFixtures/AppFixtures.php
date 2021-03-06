<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; ++$i) {
            $article = new Article();
            $article->setTitle('My title');
            $article->setContent('My content');
            $manager->persist($article);
        }

        $manager->flush();
    }
}
