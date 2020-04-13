<?php
namespace App\Service;

use App\Entity\Trajet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TrajetHistoryService
{
    private const MAX = 3;

    /** @var SessionInterface */
    private $session;

    /** @var EntityManagerInterface */
    private $em;

    /**
     * @param SessionInterface $session
     * @param EntityManagerInterface $em
     */
    public function __construct(SessionInterface $session, EntityManagerInterface $em)
    {
        $this->session = $session;
        $this->em = $em;
    }

    /**
     * @param Trajet $trajet
     *
     * @return void
     */
    public function addTrajet(Trajet $trajet) : void
    {

        $trajets = $this->getTrajetIds();

        // Ajoute l'identifiant d'un trajet au début du tableau
        array_unshift($trajets, $trajet->getId());
        dump($trajets);

        // supprimer les id. redondants
        $trajets = array_unique($trajets);

        // Garder uniquement 3 elements
        $trajets = array_slice($trajets, 0, self::MAX);
        // Sauvegarder les ids dans la session
        $this->session->set('trajet_history', $trajets);
    }

    /**
     * @return array
     */
    private function getTrajetIds() : array
    {
        return $this->session->get('Trajet_history', []);
    }

    /**
     * @return Trajet[]
     */
    public function getTrajets() : array
    {
        $jobs = [];
        $jobRepository = $this->em->getRepository(Trajet::class);
        dump($this->getTrajetIds());
        foreach ($this->getTrajetIds() as $trajetId) {
            $jobs[] = $jobRepository->find($trajetId);
        }

        return array_filter($jobs);
    }
}
