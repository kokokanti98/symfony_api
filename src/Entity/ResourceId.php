<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

// Ce fichier est pour factoriser notre code vu que l'id se repete plusieurs fois dans les entités
trait ResourceId
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}