<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Entity\Article;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        $fake = Factory::create();

        for($u = 0; $u < 10; $u++)
        {
        // Creation de notre utilisateurs
            $user = new User();
        //  Creer notre mot de passe 'password' hasher
            $passwordHash = $this->encoder->hashPassword($user,'password');
        // Set de notre champ password et email de notre utilisateur
            $user->setPassword($passwordHash)
                ->setEmail($fake->email)
                ->setAge($fake->numberBetween(15,25))
                ->setIsActif(true);
            if($u == 3){
                $user->setIsActif(false);
            }
        // Enregistrer nos données sur notre nouveau utilisateur, NB: il faut un flush pour que ca enregistre dans la bdd
            $manager->persist($user);
        // Boucle pour contruire nos articles avec un nb d'article entre 5-10 pour chq utilisateur
/*             for($a = 0; $a < \random_int(5,10); $a++)
            {
            // Creation de notre article et leur champs
                $article = (new Article())->setAuthor($user)
                                        ->setContent($fake->text(200))
                                        ->setName($fake->text(50));
            // Enregistrer notre article
                $manager->persist($article);
            } */
        }
    // Va apporter toutes nos modifs de la bdd
        $manager->flush();
    }
}
