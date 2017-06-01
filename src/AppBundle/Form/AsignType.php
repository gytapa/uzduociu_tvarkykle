<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 17.5.31
 * Time: 21.52
 */

namespace AppBundle\Form;

use AppBundle\Entity\Task;
use AppBundle\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Choice;

class AsignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $user = $options["username"];
        $categories = $options["categories"];
        $create = $options["create"];
        $builder
            ->add('Status', TextType::class, array(
                'disabled' => true,
                'data' => 'New'
            ))
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('Category', ChoiceType::class, array(
                'choices' => $categories))
            ->add('author', ChoiceType::class, array(
                'choices' => $user,
                'multiple' => true,
                'expanded' => true
            ))
            ->add('deadline_date', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Apply Changes'));

    }


    public function getDefaultOptions(array $options)
    {
        return array(
            'username'=>"none",'categories' => array(),'create' => false
        );
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Main\BlogBundle\Entity\Post',
            'validation_groups' => array('post'),
            'required' => false,
            'em' => null // this var is for your entityManager
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'username'=>"none",'categories' => array(),'create' => false
        ));
    }
}