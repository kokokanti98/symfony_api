<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

// Ce fichier est pour factoriser notre code vu que l'id se repete plusieurs fois dans les entités
trait ResourceId
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(['user_read','user_details_read','article_details_read','article_read'])]
    #[ORM\Column(type: 'integer')]
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}