<?php
/**
 * Created by PhpStorm.
 * User: jeremyclerot
 * Date: 20/12/2017
 * Time: 17:27
 */

namespace App\Controller;

use App\AppAccess;
use App\Entity\Media;
use App\AppEvent;
use App\Event\MediaEvent;
use App\Form\MediaType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route(path="/media")
 */

class MediaController extends Controller
{
    /**
     * @Route(path="/", name="media_index")
     */
    public function index()
    {
        $medias = $this->getDoctrine()->getManager()->getRepository(Media::class)->findAll();
        return $this->render('Media/index.html.twig', ['medias' => $medias]);
    }

    /**
     * @Route(path="/new", name="media_new")
     */
    public function newAction(Request $request)
    {
        $media = $this->get(Media::class);

        $form = $this->createForm(MediaType::class, $media);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $event = $this->get(MediaEvent::class);
            $event->setMedia($media);
            $dispatcher = $this->get("event_dispatcher");
            $dispatcher->dispatch(AppEvent::MEDIA_ADD, $event);

            return $this->redirectToRoute("welcome");
        }

        return $this->render("Media/new.html.twig", ["form" => $form->createView()]);
    }
}