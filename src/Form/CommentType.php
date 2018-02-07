<?php
/**
 * Created by PhpStorm.
 * User: jeremyclerot
 * Date: 20/12/2017
 * Time: 11:36
 */

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Config\Definition\IntegerNode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommentType extends AbstractType
{
    protected $token;
    protected $training;

    public function __construct(TokenStorageInterface $storage)
    {
        $this->token = $storage;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
            'training' => null,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->training= $options['training'];
        $builder
            ->add('content', TextareaType::class)
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData'])->getForm();
        ;
    }



    public function onPreSetData(FormEvent $formEvent)
    {
        $form = $formEvent->getForm();
        $comment = $formEvent->getData();

        if($comment->getId() === null){
            $comment->setUser($this->token->getToken()->getUser());
            $comment->setTraining($this->training);

            $comment->setCreatedAt(new \DateTime("now"));
            $comment->setUpdatedAt(new \DateTime("now"));
            $form->add("save", SubmitType::class, ["label" => "Create"]);
        } else{
            $comment->setUpdatedAt(new \DateTime('now'));
            $form->add("save", SubmitType::class, ["label" => "Edit"]);
        }
    }
}