<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{


    /**
     * @Route("/api/liste", name="api_liste", methods={"GET"})
     */
    public function liste(ArticleRepository $repo): Response
    {
        $tab = $repo->findAll();
        $tab["message"] = "Liste d'article'";
        return $this->json($tab);
    }

     /**
     * @Route("/api/article", name="api_ajouter", methods={"POST"})
     */
    public function ajouter(Request $req,EntityManagerInterface $em): Response
    {
        // objet PHP = un objet JS (body) 
        $objet = json_decode($req ->getContent());
        $p = new Article();
        $p->setName($objet->name);
        $p->setIsChecked($objet->isChecked);
        $em->persist($p);
        $em->flush();
        return $this->json($p);
    }

       /**
     * @Route("/api/article/{id}", name="api_modifier", methods={"PUT"})
     */
    public function modifier(Article $article,Request $req,EntityManagerInterface $em): Response
    {
       // objet PHP = un objet JS (body) 
       $objet = json_decode($req ->getContent());
       // hydrater la personne
       $article->setName($objet->name);
       $article->setIsChecked($objet->isChecked);
       $em->flush();

        return $this->json($article);
    }

          /**
     * @Route("/api/article/{id}", name="api_delete", methods={"DELETE"})
     */
    public function delete(Article $article,EntityManagerInterface $em): Response
    {
        $tab["message"] = "Enlever un article";
        $em->remove($article);
        $em->flush();
        return $this->json($tab);
    }
}
