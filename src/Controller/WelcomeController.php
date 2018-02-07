<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Training;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index()
    {
        $articles = $this->getDoctrine()->getManager()->getRepository(Article::class)->findBy(array(),array('updated_at' => 'DESC'),6);
        $trainings = $this->getDoctrine()->getManager()->getRepository(Training::class)->findBy(array(),array('updated_at' => 'DESC'),6);

        return $this->render('welcome/welcome.html.twig', ['articles' => $articles, 'trainings' => $trainings]);
    }
}
