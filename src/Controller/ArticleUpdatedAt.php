<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleUpdatedAt extends AbstractController
{
    public function __invoke(Article $data): Article
    {
    // Va faire un dump and die sur $data puis par la suite on pourra le voir sur preview de Postman
        #dd($data);
    // On va set la valeur du updatedAt
        $data->setUpdatedAt(new \DateTimeImmutable('tomorrow'));
        return $data;
    }
}
