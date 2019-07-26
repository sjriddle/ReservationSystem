<?php

namespace App\Controller;

use App\Entity\Status;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class StatusController extends Controller
{
    /**
     * @Route("/status", name="status_list")
     * @Method({"GET"})
     */
    public function index() {
      $game_items = $this->getDoctrine()->getRepository(Status::class)->findAll();

      return $this->render('status/index.html.twig', [
            'items' => $game_items,
        ]);
    }

    
  /**
   * @Route("/status/update/{id}")
   * @Method({"POST"})
   */
    public function update($id) {
        $item_id = $this->getDoctrine()->getRepository(Status::class)->find($id);
        $current_status = $item_id->getActive();

        $entityManager = $this->getDoctrine()->getManager();
        $current_status == 0 ? $item_id->setActive(1) : $item_id->setActive(0);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }
}
