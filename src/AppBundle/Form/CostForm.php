<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\CategoryEntity;
use AppBundle\Entity\CostEntity;

class CostForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'category_id',
                EntityType::class,
                array(
                    'class' => 'AppBundle:CategoryEntity',
                    'choice_label' => 'name',
                    'choice_value' => 'category_id',
                    'data_class' => 'AppBundle\Entity\CategoryEntity',
                    'required' => true
                )
            )
            ->add(
                'date_added',
                DateTimeType::class,
                array(
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'html5' => false,
                    'attr' => array(
                        'class' => 'form-control input-inline datepicker',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'yyyy-mm-dd',
                        'style' => 'width:100px;'
                    ),
                    'data' => new \DateTime(),
                    'required' => true
                )
            )
            ->add(
                'money',
                MoneyType::class,
                array(
                    'currency' => 'RUB',
                    'required' => true
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\CostEntity'
            )
        );
    }

    public function getName()
    {
        return 'app_bundle_cost_form';
    }
}
