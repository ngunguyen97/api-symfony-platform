<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/14/2020
 * Time: 3:50 PM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class PostController extends  AbstractController {
  private const POSTS = [
    [
      'id' => 1,
      'slug' => 'hello-word',
      'title' => 'Hello World'
    ],
    [
      'id' => 2,
      'slug' => 'another-post',
      'title' => 'This is another post'
    ],
    [
      'id' => 3,
      'slug' => 'last-example',
      'title' => 'This is the last example'
    ],
  ];

  /**
   * @Route("/{page}", name="blog_list", defaults={"page": 1})
   */
  public function list($page) {
    return  new JsonResponse([
      'page' => $page,
      'data' => array_map(function ($item){
        return $this->generateUrl('blog_by_id', ['id' => $item['id']]);
      },self::POSTS)
    ]);
  }

  /**
   * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"})
   * @param $id
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public function post($id) {
    return new JsonResponse(
      self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
    );
  }

  /**
   * @Route("/post/{slug}", name="blog_by_slug")
   * @param $slug
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public function postBySlug($slug) {
    return new JsonResponse(
      self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
    );
  }
}