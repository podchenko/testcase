<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Model\ActionManager;

class ProductType extends AbstractType
{
    /**
     * @var actionManager
     */
    private $actionManager;

    public function __construct(ActionManager $actionManager)
    {
        $this->actionManager = $actionManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $actions = $this->actionManager->getActions();

        $builder
            ->add('name')
            ->add('basePrice')
            ->add('specialPrices', new SpecialPriceType($actions));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_product';
    }


}
