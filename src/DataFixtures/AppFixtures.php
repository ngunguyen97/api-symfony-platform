<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

  /**
   * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface
   */
  private $passwordEncoder;

  public function __construct(UserPasswordEncoderInterface $passwordEncoder) {

    $this->passwordEncoder = $passwordEncoder;
  }

  public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);




        // composer require --dev doctrine/doctrine-fixtures-bundle
       // php bin/console doctrine:fixtures:load run this line on terminal to set into BlogPost table.
    }

    public function  loadBlogPosts(ObjectManager $manager) {
      $user = $this->getReference('user_admin');

      $blogPost = new BlogPost();
      $blogPost->setTitle('A fist post 1!');
      $blogPost->setContent('Post text');
      $blogPost->setPublished(new \DateTime('2020-07-01 12:00:00'));
      $blogPost->setAuthor($user);
      $blogPost->setSlug('a-first-post');
      $manager->persist($blogPost);

      $blogPost = new BlogPost();
      $blogPost->setTitle('A second post 2!');
      $blogPost->setContent('Post text');
      $blogPost->setPublished(new \DateTime('2020-07-01 12:00:00'));
      $blogPost->setAuthor($user);
      $blogPost->setSlug('a-second-post');
      $manager->persist($blogPost);
      $manager->flush();
    }

    public function  loadComments(ObjectManager $manager) {

    }

    public function loadUsers(ObjectManager $manager) {
      $user = new User();
      $user->setUsername('admin');
      $user->setFullname('John Doe');
      $user->setEmail('admin@gmail.com');
      $user->setPassword($this->passwordEncoder->encodePassword(
        $user,
        '123456'
      ));

      $this->addReference('user_admin', $user);

      $manager->persist($user);
      $manager->flush();
    }
}
