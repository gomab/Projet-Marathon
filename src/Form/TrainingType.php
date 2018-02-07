<?php
/**
 * Created by PhpStorm.
 * User: jeremyclerot
 * Date: 20/12/2017
 * Time: 11:36
 */

namespace App\Form;

use App\Entity\Training;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Time;
use Michelf\MarkdownExtra;



class TrainingType extends AbstractType
{
    protected $token;

    public function __construct(TokenStorageInterface $storage)
    {
        $this->token = $storage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('media', FileType::class)
            ->add('name', TextType::class)
            ->add('steps', TextareaType::class, array('attr' => array('class'=>'edit')))
            ->add('muscles', TextareaType::class, array('attr' => array('class'=>'edit')))
            ->add('difficulty', ChoiceType::class, ["choices" => [0, 1, 2, 3, 4, 5]])
            ->add('training_time', TimeType::class)
            ->add('rest_time', TimeType::class)
            ->add('materials', TextareaType::class, array('attr' => array('class'=>'edit')))
            ->add('astuce', TextareaType::class, array('attr' => array('class'=>'edit')))
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData'])->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Training::class,
        ]);
    }

    public function onPreSetData(FormEvent $formEvent)
    {
        $form = $formEvent->getForm();
        $training = $formEvent->getData();

        if($training->getId() === null){
            $training->setCreatedAt(new \DateTime("now"));
            $training->setUpdatedAt(new \DateTime("now"));
            $form->add("save", SubmitType::class, ["label" => "Create"]);
        } else{
            $training->setUpdatedAt(new \DateTime('now'));
            $form->add("save", SubmitType::class, ["label" => "Edit"]);
        }
    }
}