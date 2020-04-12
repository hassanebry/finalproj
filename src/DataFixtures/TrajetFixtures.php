<?php
namespace App\DataFixtures;

use App\Entity\Trajet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TrajetFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager) : void
    {
        $trajet1 = new Trajet();
        $trajet1->setUtilisateur($manager->merge($this->getReference('user')))
        ->setVilleDepart('Paris')
        ->setDateDepart(new \DateTime('+10 days'))
        ->setHeureDepart(new \DateTime('+1 hours'))
        ->setVilleArrive('Nantes')
        ->setDateArrive(new \DateTime('+10 days'))
        ->setHeureArrive(new \DateTime('+2 hours'))
        ->setNbrePlace(4)
        ->setNbrePlaceDispo(4)
        ->setPrix(12)
        ->setDistance(200);

        $manager->persist($trajet1);

        $trajet2 = new Trajet();
        $trajet2->setUtilisateur($manager->merge($this->getReference('user')))
        ->setVilleDepart('Marseille')
        ->setDateDepart(new \DateTime('+11 days'))
        ->setHeureDepart(new \DateTime('+1 hours'))
        ->setVilleArrive('Lille')
        ->setDateArrive(new \DateTime('+11 days'))
        ->setHeureArrive(new \DateTime('+2 hours'))
        ->setNbrePlace(4)
        ->setNbrePlaceDispo(4)
        ->setPrix(15)
        ->setDistance(100);

        $manager->persist($trajet2);

        $trajet3 = new Trajet();
        $trajet3->setUtilisateur($manager->merge($this->getReference('user')))
        ->setVilleDepart('Nice')
        ->setDateDepart(new \DateTime('+12 days'))
        ->setHeureDepart(new \DateTime('+1 hours'))
        ->setVilleArrive('Bordeaux')
        ->setDateArrive(new \DateTime('+12 days'))
        ->setHeureArrive(new \DateTime('+2 hours'))
        ->setNbrePlace(4)
        ->setNbrePlaceDispo(4)
        ->setPrix(20)
        ->setDistance(300);

        $manager->persist($trajet3);

        $trajet4 = new Trajet();
        $trajet4->setUtilisateur($manager->merge($this->getReference('user')))
        ->setVilleDepart('Strasbourg')
        ->setDateDepart(new \DateTime('+13 days'))
        ->setHeureDepart(new \DateTime('+1 hours'))
        ->setVilleArrive('Lyon')
        ->setDateArrive(new \DateTime('+13 days'))
        ->setHeureArrive(new \DateTime('+2 hours'))
        ->setNbrePlace(4)
        ->setNbrePlaceDispo(4)
        ->setPrix(25)
        ->setDistance(150);

        $manager->persist($trajet4);

        $trajet5 = new Trajet();
        $trajet5->setUtilisateur($manager->merge($this->getReference('user')))
        ->setVilleDepart('Toulouse')
        ->setDateDepart(new \DateTime('+14 days'))
        ->setHeureDepart(new \DateTime('+1 hours'))
        ->setVilleArrive('Montpellier')
        ->setDateArrive(new \DateTime('+14 days'))
        ->setHeureArrive(new \DateTime('+2 hours'))
        ->setNbrePlace(4)
        ->setNbrePlaceDispo(4)
        ->setPrix(30)
        ->setDistance(50);

        $manager->persist($trajet5);

        $trajet6 = new Trajet();
        $trajet6->setUtilisateur($manager->merge($this->getReference('user')))
        ->setVilleDepart('Rennes')
        ->setDateDepart(new \DateTime('+15 days'))
        ->setHeureDepart(new \DateTime('+1 hours'))
        ->setVilleArrive('Grenoble')
        ->setDateArrive(new \DateTime('+15 days'))
        ->setHeureArrive(new \DateTime('+2 hours'))
        ->setNbrePlace(4)
        ->setNbrePlaceDispo(4)
        ->setPrix(90)
        ->setDistance(50);

        $manager->persist($trajet6);

        $trajet7 = new Trajet();
        $trajet7->setUtilisateur($manager->merge($this->getReference('user')))
        ->setVilleDepart('Angers')
        ->setDateDepart(new \DateTime('+16 days'))
        ->setHeureDepart(new \DateTime('+1 hours'))
        ->setVilleArrive('Le Havre')
        ->setDateArrive(new \DateTime('+16 days'))
        ->setHeureArrive(new \DateTime('+2 hours'))
        ->setNbrePlace(4)
        ->setNbrePlaceDispo(4)
        ->setPrix(40)
        ->setDistance(70);

        $manager->persist($trajet7);

        $trajet8 = new Trajet();
        $trajet8->setUtilisateur($manager->merge($this->getReference('user')))
        ->setVilleDepart('Nimes')
        ->setDateDepart(new \DateTime('+17 days'))
        ->setHeureDepart(new \DateTime('+1 hours'))
        ->setVilleArrive('Dijon')
        ->setDateArrive(new \DateTime('+17 days'))
        ->setHeureArrive(new \DateTime('+2 hours'))
        ->setNbrePlace(4)
        ->setNbrePlaceDispo(4)
        ->setPrix(10)
        ->setDistance(70);

        $manager->persist($trajet8);

        $trajet9 = new Trajet();
        $trajet9->setUtilisateur($manager->merge($this->getReference('admin')))
        ->setVilleDepart('Nancy')
        ->setDateDepart(new \DateTime('+18 days'))
        ->setHeureDepart(new \DateTime('+1 hours'))
        ->setVilleArrive('Limoges')
        ->setDateArrive(new \DateTime('+18 days'))
        ->setHeureArrive(new \DateTime('+2 hours'))
        ->setNbrePlace(4)
        ->setNbrePlaceDispo(4)
        ->setPrix(80)
        ->setDistance(300);

        $manager->persist($trajet9);

        $trajet10 = new Trajet();
        $trajet10->setUtilisateur($manager->merge($this->getReference('admin')))
        ->setVilleDepart('Reims')
        ->setDateDepart(new \DateTime('+19 days'))
        ->setHeureDepart(new \DateTime('+1 hours'))
        ->setVilleArrive('Brest')
        ->setDateArrive(new \DateTime('+19 days'))
        ->setHeureArrive(new \DateTime('+2 hours'))
        ->setNbrePlace(4)
        ->setNbrePlaceDispo(4)
        ->setPrix(30)
        ->setDistance(300);

        $manager->persist($trajet10);

        

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            UtilisateurFixtures::class,
    
        ];
    }
}