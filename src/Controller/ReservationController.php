<?php
/**
 * Created by PhpStorm.
 * User: sriddle
 * Date: 4/17/19
 * Time: 5:33 PM
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\Reserve;

class ReservationController extends Controller
{
    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function index() {
        return $this->render('reserve/index.html.twig');
    }

    /**
     * @Route("/new")
     * @Method({"GET"})
     */
    public function newReservation() {
        return $this->render('reserve/new.html.twig');
    }

    /**
     * @Route("/save")
     * @Method({"GET"})
     */
    public function save() {
        $entityManager = $this->getDoctrine()->getManager();
        $reserve = new Reserve();
        
        // TODO: Create function to obtain name and time w/o hardcoding
        $reserve->setName('Test Name');
        $reserve->setTime(microtime());

        $entityManager->persist($reserve);
        $entityManager->flush();

        return new Response('Reservation ID: ' . $reserve->getId());
    }
}
