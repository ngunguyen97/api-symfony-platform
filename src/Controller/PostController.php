<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/14/2020
 * Time: 3:50 PM
 */

namespace App\Controller;

use App\Entity\BlogPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/blog")
 */
class PostController extends  AbstractController {
//  private const POSTS = [
//    [
//      'id' => 1,
//      'slug' => 'hello-word',
//      'title' => 'Hello World'
//    ],
//    [
//      'id' => 2,
//      'slug' => 'another-post',
//      'title' => 'This is another post'
//    ],
//    [
//      'id' => 3,
//      'slug' => 'last-example',
//      'title' => 'This is the last example'
//    ],
//  ];

  /**
   * @Route("/{page}", name="blog_list", defaults={"page": 1}, requirements={"page":"\d+"})
   */
  public function list($page) {
    // Fetch data from BlogPost
    $repository = $this->getDoctrine()->getRepository(BlogPost::class);
    $items = $repository->findAll();
    return  new JsonResponse([
      'page' => $page,
      'data' => array_map(function (BlogPost $item){
        return $this->generateUrl('blog_by_slug', ['slug' => $item->getSlug()]);
      }, $items)
    ]);
  }

  /**
   * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"}, methods={"GET"})
   * @ParamConverter("post", class="App:BlogPost")
   *
   * @param $post
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public function post($post) {
    return $this->json(
      #$this->getDoctrine()->getRepository(BlogPost::class)->find($id)
      $post
    );
  }

  /**
   * @Route("/post/{slug}", name="blog_by_slug")
   * @ParamConverter("post", class="App:BlogPost", options={"mapping": {"slug":"slug"}})
   * @param \App\Entity\BlogPost $post
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public function postBySlug($post) {
    return $this->json(
      #$this->getDoctrine()->getRepository(BlogPost::class)->findBy(['slug' => $slug])
      $post
    );
  }

  /**
   * @Route("/add", name="blog_add", methods={"POST"})
   * @param \Symfony\Component\HttpFoundation\Request $request
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *
   */
  public function add(Request $request) {
    /** @var Serializer $serializer */
    $serializer = $this->get('serializer');

    $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');

    $em = $this->getDoctrine()->getManager();
    $em->persist($blogPost);
    $em->flush();

    return $this->json($blogPost);
  }
    //Lecture 35 Delete entities.
  /**
   * @Route("/delete/{id}", name="blog_delete", methods={"DELETE"})
   * @param \App\Entity\BlogPost $post
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public  function delete(BlogPost $post) {
    $em = $this->getDoctrine()->getManager();
    $em->remove($post);
    $em->flush();
    return new JsonResponse(NULL, Response::HTTP_NO_CONTENT);
  }
}