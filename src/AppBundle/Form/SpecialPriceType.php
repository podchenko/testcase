<?php

namespace AppBundle\Form;

use AppBundle\Entity\Action;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Model\ActionManager;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class SpecialPriceType extends AbstractType
{
    private $actions;

    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->actions as $key => $action ) {
            $builder
                //->add('action:' . $action->getId() . '', 'text', ['data' => $action, 'mapped' => false])
                ->add('price:' . $action->getId(), null, ['label' => $action->getName()]);
        }

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_specialprice';
    }
}