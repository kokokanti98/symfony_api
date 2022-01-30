<?php

namespace App\Entity;

use App\Entity\Timestapable;
use App\Entity\ResourceId;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ArticleUpdatedAt;
use App\Repository\ArticleRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
// collectionOperations c'est pour la liste(collection) et on va afficher seulement les données avec le groupe est article_read
// itemOperations c'est pour un objet specifique(/api/article/{id} par ex) et on va afficher seulement les données avec le groupe est article_details_read
#[ApiResource(
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => 'article_read']],
        'post'
    ],
    itemOperations: [
        'get' => ['normalization_context' => ['groups' => 'article_details_read']],
        'put',
        'patch',
        'delete',
        'put_updated_at' => [
            'method' => 'POST',
            'path' => '/articles/{id}/updated-at',
            'controller' => ArticleUpdatedAt::class,
        ],
    ],
)]
class Article
{
// Contient notre champ Id
    use ResourceId;
//Contient nos dates
    use Timestapable;
// Nos autres champs
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['user_details_read','article_read','article_details_read'])]
    private $name;

    #[ORM\Column(type: 'text')]
    #[Groups(['user_details_read','article_read','article_details_read'])]
    private $content;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'articles')]
    #[Groups(['article_details_read'])]
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
