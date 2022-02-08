<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserUpdatedAtController extends AbstractController
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function __invoke(User $data): User
    {
    // Va faire un dump and die sur $data puis par la suite on pourra le voir sur preview de Postman
        //dd($data->getPassword());
    //  Creer notre mot de passe hasher
        $passwordHash = $this->encoder->hashPassword($data, $data->getPassword());
        //dd($passwordHash);
    // On va set la valeur du updatedAt
        $data->setUpdatedAt(new \DateTimeImmutable('tomorrow'));
        $data->setPassword($passwordHash);
        return $data;
    }
}
