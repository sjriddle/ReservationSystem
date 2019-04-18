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

class ReservationController extends Controller
{
    /*
     * @Route("/")
     * @Method({"GET"})
     */
    public function index() {
        return $this->render("reserve/index.html.twig");
    }
}
