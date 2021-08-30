<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingController extends AbstractController
{
    /**
     * @Route("/liste", name="liste")
     */
    public function getList(ArticleRepository $repo): Response
    {
        $listeArticles = $repo->findAll();
        return $this->render('shopping/liste.html.twig', [
            'listeArticles' => $listeArticles,
        ]);
    }

    /**
     * @Route("/addArticle", name="addArticle")
     */
    public function addArticle(Request $req, EntityManager $em): Response
    {
        $name = $req->get('name');
        $article = new Article();
        $article->setName($name);
        $article->setIsChecked(false);
        $em->persist($article);
        $em->flush();
        return $this->redirectToRoute('liste');
    }

    /**
     * @Route("/delete/{id}", name="deleteArticle")
     */
    public function deleteArticle(Article $article, EntityManager $em): Response
    {
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('liste');
    }

    /**
     * @Route("/check/{id}", name="checkArticle")
     */
    public function checkArticle(Article $article, EntityManagerInterface $em): Response
    {
        $article->setIsChecked(!$article->getIsChecked());
        $em->persist($article);
        $em->flush();
        return $this->redirectToRoute('liste');
    }
}
