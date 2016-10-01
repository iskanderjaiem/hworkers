<?php
// src/AppBundle/Form/PostulationType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostulationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('email')
            ->add('commentaire')
            ->add('postuler', SubmitType::class)
        ;
    }  /**
       * @param OptionsResolver $resolver
       */
      public function configureOptions(OptionsResolver $resolver)
      {
          $resolver->setDefaults(array(
              'data_class' => 'AdminBundle\Entity\Postulation'
          ));
      }
}
