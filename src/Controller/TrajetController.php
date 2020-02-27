<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Entity\Utilisateur;
use App\Form\TrajetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrajetController extends AbstractController
{
    /**
     * Lister tous les trajet.
     * @Route("/trajet/", name="trajet.list")
     * @return Response
     */
    public function list() : Response
    {
    
        $trajets = $this->getDoctrine()->getRepository(Trajet::class)->findAll();
        return $this->render('trajet/list.html.twig', [
        'trajets' => $trajets,
        ]);
    }

    /**
     * Chercher et afficher un trajet.
     * @Route("/trajet/{id}", name="trajet.show", requirements={"id" = "\d+"})
     * @param Trajet $trajet
     * @return Response
     */
    public function show(Trajet $trajet) : Response
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find(1);
        $trajet->setUtilisateur($user);
        return $this->render('trajet/show.html.twig', [
        'trajet' => $trajet,
    ]);
}

/**
	* Créer un nouveau trajet.
	* @Route("/nouveau-trajet", name="trajet.create")
	* @param Request $request
	* @param EntityManagerInterface $em
	* @return RedirectResponse|Response
	*/
	public function create(Request $request, EntityManagerInterface $em) : Response
	{
		$trajet = new Trajet();
		$form = $this->createForm(TrajetType::class, $trajet);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
		$em->persist($trajet);
		$em->flush();
		return $this->redirectToRoute('trajet.list');
	}
		return $this->render('trajet/create.html.twig', [
		'form' => $form->createView(),
		]);
	}


}
