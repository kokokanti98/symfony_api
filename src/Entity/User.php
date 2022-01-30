<?php

namespace App\Entity;
use App\Entity\Timestapable;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\ResourceId;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
// collectionOperations c'est pour la liste(collection) et on va afficher seulement les données avec le groupe est user_read
// itemOperations c'est pour un objet specifique(/api/user/{id} par ex) et on va afficher seulement les données avec le groupe est user_details_read
#[ApiResource(
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => 'user_read']],
        'post'
    ],
    itemOperations: [
        'get' => ['normalization_context' => ['groups' => 'user_details_read']],
        'put',
        'patch',
        'delete'
    ],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
// Contient notre champ Id
    use ResourceId;
//Contient nos dates
    use Timestapable;
// Nos autres champs
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(['user_read','user_details_read','article_details_read'])]
    private $email;

    #[ORM\Column(type: 'json')]
    #[Groups(['user_details_read'])]
    private $roles = [];
// On affichera le password que seulement qu'on on va recuperer les infos d un utilisateur specifique(par son id par exemple)
    #[ORM\Column(type: 'string')]
    #[Groups(['user_details_read'])]
    private $password;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Article::class, orphanRemoval: true)]
    #[Groups(['user_details_read'])]
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        #$this->createdAt = new DateTimeImmutable();  
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }


    
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

        return $this;
    }
}
