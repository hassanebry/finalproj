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


/**
 * @Route("/{_locale}/reservaion/")
 */
class ReservationController extends AbstractController
{
    /**
	* Effectuer une reservation.
	* @Route("new-reservation/{slug}", name="reservation.create", requirements={"slug" = "[a-zA-Z]+"})
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
		if ($place_dispo > $place_reserv || $place_dispo == $place_reserv){
			$trajet->setNbrePlace($place_dispo - $place_reserv);
		}else{
			return $this->redirectToRoute('reservation.error');
		}
		$em->flush();
		return $this->redirectToRoute('reservation1.list');
	}
		return $this->render('reservation/create.html.twig', [
        'form' => $form->createView(),
        'trajet' => $trajet,
        'reservation' => $reservation,
		]);
	}
	
	/**
     * Afficher un message derreur.
     * @Route("error", name="reservation.error")
     * @return Response
     */
    public function error_reserv() : Response
    {
        return $this->render('reservation/noreserv.html.twig');
    }

    /**
     * Lister les reservations d'un user.
     * @Route("mesreservations", name="reservation.list")
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

    /**
     * Lister les reservations d'un user.
     * @Route("mesreservations1", name="reservation1.list")
     * @return Response
     */
    public function list1() : Response
    {
        $user = $this->getUser();
		$reservations = $this->getDoctrine()->getRepository(Reservation::class)->findby(['utilisateur' => $user]);
        return $this->render('reservation/list1.html.twig', [
		'reservations' => $reservations,
        ]);
    }

    /**
	 * Éditer une reservation.
	 * @Route("{id}/edit", name="reservation.edit", requirements={"id" = "\d+"})
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @return RedirectResponse|Response
	*/
	public function edit(Request $request, Reservation $reservation, EntityManagerInterface $em) : Response
	{
		$form = $this->createForm(ReservationType::class, $reservation);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
		$em->flush();
		return $this->redirectToRoute('reservation.list');
		}
		return $this->render('reservation/edit.html.twig', [
		'form' => $form->createView(),
		]);
    }
    
    /**
	* Supprimer une reservation.
	* @Route("{id}/delete", name="reservation.delete", requirements={"id" = "\d+"})
	* @param Request $request
	* @param Reservation $reservation
	* @param EntityManagerInterface $em
	* @return Response
	*/
	public function delete(Request $request, Reservation $reservation, EntityManagerInterface $em) : Response
	{
	$form = $this->createFormBuilder()
	->setAction($this->generateUrl('reservation.delete', ['id' => $reservation->getId()]))
	->getForm();
	$form->handleRequest($request);
	if ( ! $form->isSubmitted() || ! $form->isValid()) {
	return $this->render('reservation/delete.html.twig', [
	'reservation' => $reservation,
	'form' => $form->createView(),
	]);
	}
	$em = $this->getDoctrine()->getManager();
	$em->remove($reservation);
	$em->flush();
	return $this->redirectToRoute('reservation.list');
	}
}
