<?php
/**
 * Created by PhpStorm.
 * User: thomasdebacker
 * Date: 21/12/2017
 * Time: 08:30
 */

namespace App\Form;

use App\Entity\Vote;
use Symfony\Component\Config\Definition\IntegerNode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class VoteType extends AbstractType
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
            'data_class' => Vote::class,
            'training' => null,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->training= $options['training'];
        $builder
            ->add('value', ChoiceType::class, ["choices" => [0, 1, 2, 3, 4, 5]])
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData'])->getForm();
        ;
    }

    public function onPreSetData(FormEvent $formEvent)
    {
        $form = $formEvent->getForm();
        $vote = $formEvent->getData();

        $vote->setUser($this->token->getToken()->getUser());
        $vote->setTraining($this->training);

        $form->add("save", SubmitType::class, ["label" => "Create"]);
    }
}