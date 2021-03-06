<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Entity\Stage;
use AdminBundle\Form\StageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class DefaultController extends Controller
{
public function indexAction()
{
  return $this->render('AdminBundle:admin:index.html.twig');
}
public function listeStagesAction()
{
  $em = $this->getDoctrine()->getManager();

          $stages = $em->getRepository('AdminBundle:Stage')->findAll();

          return $this->render('AdminBundle:admin:listeStages.html.twig', array('entities' => $stages));
}
public function ajoutStageAction(Request $request)
{

      $stage = new Stage();

      $form = $this->createFormBuilder($stage)
          ->add('titre')
          ->add('description')
          ->add('image')
          ->add('submit', SubmitType::class, array('attr' => array('class' => 'btn sbold green')))
          ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($stage);
          $em->flush();

          $stages = $em->getRepository('AdminBundle:Stage')->findAll();
          return $this->render('AdminBundle:admin:listeStages.html.twig', array('entities' => $stages));
      }

      return $this->render('AdminBundle:admin:ajoutStage.html.twig', array(
          'stage' => $stage,
          'form' => $form->createView(),
      ));
}
}
