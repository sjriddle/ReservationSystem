<?php
namespace App\Controller;

use App\Entity\Reserve;
use MongoDB\BSON\UTCDateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use DateTimeZone;


class ReservationController extends Controller
{
    /**
     * @Route("/", name="reservation_list")
     * @Method({"GET"})
     */
    public function index(Request $request) {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $paginator  = $this->get('knp_paginator');
        $all_reservations = $this->getDoctrine()->getRepository(Reserve::class)->findAll();
        $filtered_reservations = [];
        foreach($all_reservations as $res) {
            if ($res->getResDate()->format('m/d/y') >= date('m/d/y', strtotime('-1 days'))) {
                $filtered_reservations[] = $res;
            }
        }

        $reservations = $paginator->paginate($filtered_reservations, $request->query->getInt('page', 1), 10);
        return $this->render('reserve/index.html.twig', [
            'reservations' => $reservations
        ]);
    }


    /**
     * @Route("/reserve/new", name="reservation_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer) {
        $reservation = new Reserve();
        $form = $this->createFormBuilder($reservation)
            ->add('first_name', TextType::class, [
                'required' => true,
                'label' => 'First Name',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('last_name', TextType::class, [
                'required' => true,
                'label' => 'Last Name',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email', TextType::class, [
              'required' => true,
              'attr' => [
                'class' => 'form-control'
              ]
            ])
            ->add('guest_count', IntegerType::class, [
                'required' => true,
                'label' => 'Number of Guests',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('res_date', DateType::class, [
                'label' => 'Reservation Date',
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker'
                ]
            ])
            ->add('res_time', TimeType::class, [
                'label' => 'Reservation Time',
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create',
                'attr' => [
                  'class' => 'btn uvu-btn mt-3'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $res_form = $form->getData();
            $res_time = $res_form->getResTime();

            $datetime = new \DateTime();
            $previous_hour = new \DateTime('+1 hours');
            $timezone = new DateTimeZone('America/Denver');
            $previous_hour->setTimezone($timezone);
            $datetime->setTimezone($timezone);


            if ($res_time->format('h:i A') < $datetime->format('h:i A')) {
                return $this->redirectToRoute('reservation_time');
            } else if ($res_time->format('h:i A') < $previous_hour->format('h:i A')) {
                return $this->redirectToRoute('reservation_time');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($res_form);
            $entityManager->flush();

            $id = $res_form->getId();
            $email = $res_form->getEmail();
            $reservations = $this->getDoctrine()->getRepository(Reserve::class)->find($id);

            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('uvu.reservation@gmail.com')
                ->setTo($email)
                ->setBody($this->renderView('emails/confirmation.html.twig',
                    ['reservations' => $reservations]), 'text/html');
            $mailer->send($message);
            return $this->redirect('/reserve/'.$id);
        }

        return $this->render('reserve/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/reserve/edit/{id}", name="reservation_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $reservation = $this->getDoctrine()->getRepository(Reserve::class)->find($id);
        if (!$reservation) {
            return $this->redirectToRoute('reservation_error');
        }

        $form = $this->createFormBuilder($reservation)
            ->add('first_name', TextType::class, [
                'required' => true,
                'label' => 'First Name',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('last_name', TextType::class, [
                'required' => true,
                'label' => 'Last Name',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email', TextType::class, [
              'required' => true,
              'attr' => [
                'class' => 'form-control'
              ]
            ])
            ->add('guest_count', IntegerType::class, [
                'required' => true,
                'label' => 'Number of Guests',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('res_date', DateType::class, [
                'label' => 'Reservation Date',
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker'
                ]
            ])
            ->add('res_time', TimeType::class, [
                'label' => 'Reservation Time',
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Update',
                'attr' => [
                  'class' => 'btn uvu-btn mt-3'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirect('/reserve/'.$id);
        }

        return $this->render('reserve/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/reserve/error", name="reservation_error")
     * @Method({"GET"})
     */
    public function error() {
        $reservations = $this->getDoctrine()->getRepository(Reserve::class)->findAll();
        return $this->render('reserve/error.html.twig', [
            'reservations' => $reservations
        ]);
    }

    /**
     * @Route("/reserve/time", name="reservation_time")
     * @Method({"GET"})
     */
    public function time() {
      $reservations = $this->getDoctrine()->getRepository(Reserve::class)->findAll();
      return $this->render('reserve/time.html.twig', [
        'reservations' => $reservations
      ]);
    }

    /**
     * @Route("/reserve/find", name="reservation_find")
     * @Method({"GET"})
     */
    public function find() {
        $reservations = $this->getDoctrine()->getRepository(Reserve::class)->findAll();
        return $this->render('reserve/find.html.twig', [
            'reservations' => $reservations
        ]);
    }


    /**
     * @Route("/reserve/{id}", name="reservation_show")
     */
    public function show($id) {
        $reservation = $this->getDoctrine()->getRepository(Reserve::class)->find($id);
        return $this->render('reserve/show.html.twig', [
            'reservation' => $reservation
        ]);
    }


    /**
     * @Route("/reserve/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete($id) {
        $reservation = $this->getDoctrine()->getRepository(Reserve::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reservation);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }
}
