<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Michelf\MarkdownExtra;

class ArticleType extends AbstractType
{
    protected $token;

    public function __construct(TokenStorageInterface $storage)
    {
        $this->token = $storage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, (array('attr' => array('class'=>'edit'))))
            ->add('summary', TextType::class, (array('attr' => array('class'=>'edit'))))
            ->add('content', TextareaType::class, (array('attr' => array('class'=>'edit'))))
            ->add('media', FileType::class)
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData'])->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

    public function onPreSetData(FormEvent $formEvent)
    {
        $form = $formEvent->getForm();
        $article = $formEvent->getData();

        if($article->getId() === null){
            $article->setUser($this->token->getToken()->getUser());
            $article->setCreatedAt(new \DateTime("now"));
            $article->setUpdatedAt(new \DateTime("now"));
            $article->setHitcount(0);
            $form->add("save", SubmitType::class, ["label" => "Create"]);
        } else{
            $article->setUpdatedAt(new \DateTime('now'));
            $form->add("save", SubmitType::class, ["label" => "Edit"]);
        }
    }
}