<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Reservation;
use App\Entity\Trajet;
use App\Entity\Utilisateur;
use App\Form\ReservationType;

class ReservationController extends AbstractController
{
    /**
	* Effectuer une reservation.
	* @Route("new-reservation/{id}", name="reservation.create", requirements={"id" = "\d+"})
	* @param Request $request
	* @param EntityManagerInterface $em
	* @return RedirectResponse|Response
	*/
	public function create(Trajet $trajet, Request $request, EntityManagerInterface $em) : Response
	{
		$reservation = new Reservation();
		$form = $this->createForm(ReservationType::class, $reservation);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($reservation);
        $reservation->setUtilisateur($this->getUser());
        $reservation->setTrajet($trajet);
        $place_dispo = $trajet->getNbrePlace();
        $place_reserv = $reservation->getNbrePlace();
        $trajet->setNbrePlace($place_dispo - $place_reserv);
		$em->flush();
		#return $this->redirectToRoute('reservation/show.html.twig');
	}
		return $this->render('reservation/create.html.twig', [
        'form' => $form->createView(),
        'trajet' => $trajet,
        'reservation' => $reservation,
		]);
    }

    /**
     * Lister les reservations d'un user.
     * @Route("reservation/", name="reservation.list")
     * @return Response
     */
    public function list() : Response
    {
        $user = $this->getUser();
		$reservations = $this->getDoctrine()->getRepository(Reservation::class)->findby(['utilisateur' => $user]);
        return $this->render('reservation/list.html.twig', [
		'reservations' => $reservations,
        ]);
    }
}
