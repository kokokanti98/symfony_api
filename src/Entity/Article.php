<?php

namespace App\Entity;

use App\Entity\Timestapable;
use App\Entity\ResourceId;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ArticleRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource]
class Article
{
// Contient notre champ Id
    use ResourceId;
//Contient nos dates
    use Timestapable;
// Nos autres champs
    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private $author;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable(); 
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;
        #$this->author->addArticle($this);
        return $this;
    }
}
