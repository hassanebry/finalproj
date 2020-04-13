<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trajet;
use App\Entity\Commentaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CommentaireType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/{_locale}/commentaire/")
 */
class CommentaireController extends AbstractController
{
    
    /**
     * Chercher et afficher un commentaire.
     * @Route("commentaires/", name="commentaire.list")
     * @return Response
	 * @IsGranted("ROLE_USER")
     */
    public function list(): Response
    {
        $user = $this->getUser();
		$commentaire = $this->getDoctrine()->getRepository(Commentaire::class)->findby(['utilisateur' => $user]);
        return $this->render('commentaire/list.html.twig', [
        'commentaires' => $commentaire,
    ]);
    }
    
    /**
	* Faire un commentaire.
	* @Route("new-commentaire/{slug}", name="commentaire.create", requirements={"slug" = "[a-zA-Z]+"})
	* @param Request $request
	* @param EntityManagerInterface $em
	* @return RedirectResponse|Response
	* @IsGranted("ROLE_USER")
	*/
    public function create(Trajet $trajet, Request $request, EntityManagerInterface $em): Response
	{
        $commentaire = new Commentaire();
		$form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        
		if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($commentaire);
            $commentaire->setUtilisateur($this->getUser());
            $commentaire->setTrajet($trajet);
            $em->flush();
            return $this->redirectToRoute('commentaire.list');
        }

	return $this->render('commentaire/create.html.twig', [
        'form' => $form->createView(),
        'trajet' => $trajet,
        'commentaire' => $commentaire,
		]);
		
    }

    /**
	 * Éditer un commentaire.
	 * @Route("{id}/edit", name="commentaire.edit", requirements={"id" = "\d+"})
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @return RedirectResponse|Response
	 * @IsGranted("ROLE_USER")
	*/
	public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $em) : Response
	{
		$form = $this->createForm(CommentaireType::class, $commentaire);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
		$em->flush();
		return $this->redirectToRoute('commentaire.list');
		}
		return $this->render('commentaire/edit.html.twig', [
		'form' => $form->createView(),
		]);
    }
    
    /**
	* Supprimer un commentaire.
	* @Route("{id}/delete", name="commentaire.delete", requirements={"id" = "\d+"})
	* @param Request $request
	* @param Commentaire $commentaire
	* @param EntityManagerInterface $em
	* @return Response
	* @IsGranted("ROLE_USER")
	*/
	public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $em) : Response
	{
	$form = $this->createFormBuilder()
	->setAction($this->generateUrl('commentaire.delete', ['id' => $commentaire->getId()]))
	->getForm();
	$form->handleRequest($request);
	if ( ! $form->isSubmitted() || ! $form->isValid()) {
	return $this->render('commentaire/delete.html.twig', [
	'commentaire' => $commentaire,
	'form' => $form->createView(),
	]);
	}
	$em = $this->getDoctrine()->getManager();
	$em->remove($commentaire);
	$em->flush();
	return $this->redirectToRoute('commentaire.list');
	}

}
