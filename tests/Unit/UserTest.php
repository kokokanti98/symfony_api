<?php

namespace App\Tests\Unit;

use App\Entity\Article;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = new User();
    }
// Fonction test pour tester si le champ Email marche
    public function testGetEmail(): void
    {
    // Valeur de test
        $value = 'test@test.fr';

        $response = $this->user->setEmail($value);
        $getEmail = $this->user->getEmail();

    // Va voir si $response est une instance de la classe User
        $this->assertInstanceOf(User::class,  $this->user);
    // Va voir si $value est égal a user->getEmail()
        $this->assertEquals($value, $this->user->getEmail());
    // Va voir si $value est egale à son email-> retourne vrai aussi 
        $this->assertEquals($value, $this->user->getUserIdentifier());
        
    }
// Test du champ role
    public function TestGetRoles(): void
    {
        $value = ['ROLE_ADMIN'];
        $response = $this->user->setRoles($value);
    // Va voir si $response est une instance de la classe User
        $this->assertInstanceOf(User::class,  $response);
    // Va voir si l utilisateur possede le role user
        $this->assertContains('ROLE_USER',$this->user->getRoles());
    // Va voir si l utilisateur possede le role admin
        $this->assertContains('ROLE_ADMIN',$this->user->getRoles());
    }
// Test du champ password
    public function TestGetPassword(): void
    {
        $value = 'password';
        $response = $this->user->setPassword($value);
    // Va voir si $response est une instance de la classe User
        $this->assertInstanceOf(User::class,  $response);
    // Va voir si $this->user->getPassword()) a une valeur $value
        $this->assertEquals($value,$this->user->getPassword());
    }
// Test du champ password
    public function TestGetArticle(): void
    {
        $value = new Article();
        $response = $this->user->addArticle($value);
    // Va voir si $response est une instance de la classe User
        $this->assertInstanceOf(User::class,  $response);
    // Va voir si il y a 1 pour nb des articles dans articles
        $this->assertCount(1,$this->user->getArticles());
    // Va voir si liste articles contien l'article $value
        $this->assertTrue($this->user->getArticles()->contains($value));

        $response = $this->user->removeArticle($value);
    // Va voir si $response est une instance de la classe User
        $this->assertInstanceOf(User::class,  $response);
    // Va voir si il y a 1 pour nb des articles dans articles
        $this->assertCount(0,$this->user->getArticles());
    // Va voir si liste articles contien l'article $value
        $this->assertFalse($this->user->getArticles()->contains($value));
    }
}
