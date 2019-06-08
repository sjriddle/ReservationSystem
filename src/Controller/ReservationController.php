<?php
namespace App\Controller;

use App\Entity\Reserve;
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



class ReservationController extends Controller
{
    /**
     * @Route("/", name="reservation_list")
     * @Method({"GET"})
     */
    public function index() {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $reservations = $this->getDoctrine()->getRepository(Reserve::class)->findAll();

        return $this->render('reserve/index.html.twig', [
            'reservations' => $reservations
        ]);
    }

    /**
     * @Route("/reserve/new", name="reservation_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $reservation = new Reserve();

        $form = $this->createFormBuilder($reservation)
            ->add('first_name', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('last_name', TextType::class, [
                'required' => true,
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
                    'class' => 'btn btn-success mt-3'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $res_form = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($res_form);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_success');
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
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('last_name', TextType::class, [
                'required' => true,
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
                    'class' => 'btn btn-success mt-3'
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
