<?php

namespace App\Controller;

use App\AppAccess;
use App\Entity\Article;
use App\Entity\Media;
use App\AppEvent;
use App\Event\ArticleEvent;
use App\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Michelf\MarkdownExtra;
use Michelf\Markdown;

/**
 * @Route(path="/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route(path="/", name="article_index")
     */
    public function index()
    {
        $articles = $this->getDoctrine()->getManager()->getRepository(Article::class)->findBy(array(), array('hitcount' => 'desc'));

        return $this->render('Article/index.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route(path="/show/{id}", name="article_show")
     */
    public function show(Article $article)
    {
        $article->setHitcount($article->getHitcount()+1);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->render('Article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route(path="/new", name="article_new")
     */
    public function newAction(Request $request)
    {
        $article = $this->get(Article::class);

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        
            $date = date_create();
            $someNewFilename = date_timestamp_get($date);
            $dir = "../public/uploads/";
            $file = $form['media']->getData();
            
            if($file->guessExtension() != null){
                $someNewFilename = $someNewFilename.'.'.$file->guessExtension();
            }
    
            $file->move($dir, $someNewFilename);

            $media = new Media();
            $media->setPath($someNewFilename);
            $media->setType("photo");
            $media->setTitle($someNewFilename);

            $event = $this->get(ArticleEvent::class);
            $event->setArticle($article);
            $event->setMedia($media);
            $dispatcher = $this->get("event_dispatcher");
            $dispatcher->dispatch(AppEvent::ARTICLE_ADD, $event);

            return $this->redirectToRoute("article_index");
        }

        return $this->render("Article/new.html.twig", ["form" => $form->createView()]);
    }


    /**
     * @Route(path="/edit/{id}", name="article_edit")
     */
    public function editAction(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $event = $this->get(ArticleEvent::class);
            $event->setArticle($article);
            $dispatcher = $this->get("event_dispatcher");
            $dispatcher->dispatch(AppEvent::ARTICLE_EDIT, $event);

            return $this->redirectToRoute("article_show", ["id" => $article->getId()]);
        }

        return $this->render("Article/edit.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route(path="/delete/{id}", name="article_delete")
     */
    public function deleteAction(Article $article)
    {
        $event = $this->get(ArticleEvent::class);
        $event->setArticle($article);
        $dispatcher = $this->get("event_dispatcher");
        $dispatcher->dispatch(AppEvent::ARTICLE_DELETE, $event);

        return $this->redirectToRoute("article_index");

    }
}