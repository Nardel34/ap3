<?php

namespace App\DataFixtures;

use App\Entity\Evenement;
use App\Entity\Lieu;
use App\Entity\Personnes;
use App\Entity\Tarifs;
use App\Entity\Type;
use App\Repository\LieuRepository;
use App\Repository\TarifsRepository;
use App\Repository\TypeRepository;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        protected UserPasswordHasherInterface $hasher,
        protected TarifsRepository $tarifsRepository,
        protected LieuRepository $lieuRepository,
        protected TypeRepository $typeRepository
    ) {
    }

    public function load(ObjectManager $manager): void
    {


        $tarifs1 = new Tarifs;
        $tarifs1->setTrancheAge('6 - 18 ans')
            ->setPrix('500');
        $tarifs2 = new Tarifs;
        $tarifs2->setTrancheAge('18 - 50 ans')
            ->setPrix('1000');
        $manager->persist($tarifs1);
        $manager->persist($tarifs2);

        $type1 = new Type;
        $type1->setNomType('Concerto')
            ->setDescription('Petit concert');
        $type2 = new Type;
        $type2->setNomType('Cours de solfège')
            ->setDescription('Apprender à lire une partition');
        $type3 = new Type;
        $type3->setNomType('Duo avec violoncelle')
            ->setDescription('Entrainement à la synchronisation');
        $manager->persist($type1);
        $manager->persist($type2);
        $manager->persist($type3);

        $lieu1 = new Lieu;
        $lieu1->setAdresseLieu('1 rue des pro');
        $lieu2 = new Lieu;
        $lieu2->setAdresseLieu('2 rue des pigeon');
        $lieu3 = new Lieu;
        $lieu3->setAdresseLieu('3 rue des violoniste');
        $manager->persist($lieu1);
        $manager->persist($lieu2);
        $manager->persist($lieu3);

        $manager->flush();


        $prof = new Personnes();
        $prof->setEmail('prof@gmail.com')
            ->setPassword($this->hasher->hashPassword($prof, 'aze'))
            ->setNom('CAROLO')
            ->setPrenom('Christophe')
            ->setRoles(["ROLE_PROF"])
            ->setAge('30')
            ->setDiplome('prof')
            ->setExpPro('profpro');

        $prof2 = new Personnes();
        $prof2->setEmail('prof2@gmail.com')
            ->setPassword($this->hasher->hashPassword($prof2, 'aze'))
            ->setNom('KALLAL')
            ->setPrenom('Hatem')
            ->setRoles(["ROLE_PROF"])
            ->setAge('30')
            ->setDiplome('prof2')
            ->setExpPro('profpro2');

        $manager->persist($prof);
        $manager->persist($prof2);

        $eleve = new Personnes();
        $eleve->setEmail('eleve@gmail.com')
            ->setPassword($this->hasher->hashPassword($eleve, 'aze'))
            ->setNom('JEUNE')
            ->setPrenom('Élève')
            ->setRoles(["ROLE_ELEVE"])
            ->setAge('12')
            ->setDateEntree(date_format(date_create('now'), 'd-m-Y'))
            ->setTarifs($this->tarifsRepository->findOneBy(['id' => 26]));

        $manager->persist($eleve);

        $manager->flush();

        $event1 = new Evenement;
        $event1->setDateEvent(new DateTime('now'))
            ->setType($type1)
            ->setLieu($lieu1)
            ->setPersonnes($prof);
        $event2 = new Evenement;
        $event2->setDateEvent(new DateTime('now'))
            ->setType($type2)
            ->setLieu($lieu2)
            ->setPersonnes($prof);
        $event3 = new Evenement;
        $event3->setDateEvent(new DateTime('now'))
            ->setType($type3)
            ->setLieu($lieu2)
            ->setPersonnes($prof);
        $manager->persist($event1);
        $manager->persist($event2);
        $manager->persist($event3);

        $manager->flush();
    }
}
