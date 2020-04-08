<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Repository\TrajetRepository;
use App\Entity\TrajetSearch;
use App\Entity\Utilisateur;
use App\Form\TrajetSearchType;
use App\Form\TrajetType;
use App\Service\TrajetHistoryService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
*@Route("/{_locale}/")
*/
class TrajetController extends AbstractController
{
    /**
     * Lister tous les trajet.
     * @Route("trajet/", name="trajet.list")
     * @return Response
     */
    public function list(TrajetHistoryService $trajetHistoryService) : Response
    {

		$trajets = $this->getDoctrine()->getRepository(Trajet::class)->findAll();
		dump($trajetHistoryService->getTrajets());
        return $this->render('trajet/list.html.twig', [
		'trajets' => $trajets,
		'historyTrajets' => $trajetHistoryService->getTrajets(),
        ]);
    }

    /**
     * Chercher et afficher un trajet.
     * @Route("trajet/{id}", name="trajet.show", requirements={"id" = "\d+"})
     * @param Trajet $trajet
     * @return Response
     */
    public function show(Trajet $trajet, TrajetHistoryService $trajetHistoryService) : Response
    {
		$trajetHistoryService->addTrajet($trajet);
		dump($trajetHistoryService->getTrajets());
        return $this->render('trajet/show.html.twig', [
        'trajet' => $trajet,
    ]);
}

	/**
	* Créer un nouveau trajet.
	* @Route("nouveau-trajet", name="trajet.create")
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
        $trajet->setUtilisateur($this->getUser());
		$em->flush();
		return $this->redirectToRoute('trajet.list');
	}
		return $this->render('trajet/create.html.twig', [
		'form' => $form->createView(),
		]);
    }
    
    /**
	 * Éditer un trajet.
	 * @Route("trajet/{id}/edit", name="trajet.edit", requirements={"id" = "\d+"})
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @return RedirectResponse|Response
	*/
	public function edit(Request $request, Trajet $trajet, EntityManagerInterface $em) : Response
	{
		$form = $this->createForm(TrajetType::class, $trajet);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
		$em->flush();
		return $this->redirectToRoute('trajet.list');
		}
		return $this->render('trajet/create.html.twig', [
		'form' => $form->createView(),
		]);
	}

    /**
	* Supprimer un trajet.
	* @Route("trajet/{id}/delete", name="trajet.delete", requirements={"id" = "\d+"})
	* @param Request $request
	* @param trajet $trajet
	* @param EntityManagerInterface $em
	* @return Response
	*/
	public function delete(Request $request, Trajet $trajet, EntityManagerInterface $em) : Response
	{
	$form = $this->createFormBuilder()
	->setAction($this->generateUrl('trajet.delete', ['id' => $trajet->getId()]))
	->getForm();
	$form->handleRequest($request);
	if ( ! $form->isSubmitted() || ! $form->isValid()) {
	return $this->render('trajet/delete.html.twig', [
	'trajet' => $trajet,
	'form' => $form->createView(),
	]);
	}
	$em = $this->getDoctrine()->getManager();
	$em->remove($trajet);
	$em->flush();
	return $this->redirectToRoute('trajet.list');
	}

	/**
     * Lister les trajet depuis un champs.
     * @Route("trajet/search", name="trajet.search")
     * @return Response
     */
    public function search(TrajetRepository $repository, Request $request) 
    {
		$data = new TrajetSearch;
		$form = $this->createForm(TrajetSearchType::class, $data);
		$form->handleRequest($request);
		$trajets = $repository->findSearch($data);
        return $this->render('trajet/search.html.twig', [
		'current_menu' => 'trajets',
		'trajets' => $trajets,
		'form' => $form->createView()
		]);

		
		
		
	}
	
	/**
     * Lister les trajets d'un user.
     * @Route("trajet/mestrajets", name="trajet.malist")
     * @return Response
     */
    public function malist() : Response
    {
        $user = $this->getUser();
		$trajets = $this->getDoctrine()->getRepository(Trajet::class)->findby(['utilisateur' => $user]);
        return $this->render('trajet/malist.html.twig', [
		'trajets' => $trajets,
        ]);
    }

}
