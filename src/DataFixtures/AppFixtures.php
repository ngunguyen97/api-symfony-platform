<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Comment;
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

  private $faker;

  public function __construct(UserPasswordEncoderInterface $passwordEncoder) {

    $this->passwordEncoder = $passwordEncoder;
    $this->faker = \Faker\Factory::create();

  }

  public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
        $this->loadComments($manager);




        // composer require --dev doctrine/doctrine-fixtures-bundle
       // php bin/console doctrine:fixtures:load run this line on terminal to set into BlogPost table.
      // composer require --dev fzaninotto/faker using to fake data.
    }

  public function  loadBlogPosts(ObjectManager $manager) {
      $user = $this->getReference('user_admin');
       for ($i = 0; $i < 10; $i++) {
         $blogPost = new BlogPost();
         $blogPost->setTitle($this->faker->realText(30));
         $blogPost->setContent($this->faker->realText());
         $blogPost->setPublished($this->faker->dateTimeThisYear);
         $blogPost->setAuthor($user);
         $blogPost->setSlug($this->faker->slug);
         $this->setReference("blog_post_$i", $blogPost);
         $manager->persist($blogPost);
       }

       $manager->flush();

    }

    public function  loadComments(ObjectManager $manager) {
      for ($i = 0; $i < 10; $i++) {
        for ($j = 0; $j < rand(1, 10); $j++) {
          $comment = new Comment();
          $comment->setContent($this->faker->realText());
          $comment->setAuthor($this->getReference('user_admin'));
          $comment->setPublished($this->faker->dateTimeThisYear);

          $manager->persist($comment);
        }
      }
      $manager->flush();
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
