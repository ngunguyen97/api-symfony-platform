<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $blogPost = new BlogPost();
        $blogPost->setTitle('A fist post 1!');
        $blogPost->setContent('Post text');
        $blogPost->setPublished(new \DateTime('2020-07-01 12:00:00'));
        $blogPost->setAuthor('John Doe');
        $blogPost->setSlug('a-first-post');
        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle('A second post 2!');
        $blogPost->setContent('Post text');
        $blogPost->setPublished(new \DateTime('2020-07-01 12:00:00'));
        $blogPost->setAuthor('John Doe');
        $blogPost->setSlug('a-second-post');
        $manager->persist($blogPost);
        $manager->flush();

        // composer require --dev doctrine/doctrine-fixtures-bundle
       // php bin/console doctrine:fixtures:load run this line on terminal to set into BlogPost table.
    }
}
