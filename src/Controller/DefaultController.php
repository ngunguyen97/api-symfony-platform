<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/14/2020
 * Time: 3:33 PM
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class DefaultController extends AbstractController {
  /**
   * @Route("/", name="default_index")
   */
  public  function  index() {
    return new JsonResponse([
      'action' => 'index',
      'time' => time()
    ]);
  }
}