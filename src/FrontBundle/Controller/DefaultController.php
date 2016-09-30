<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
  public function indexAction()
  {
    return $this->render('FrontBundle::index.html.twig');
  }

  public function stagesAction()
  {
    $em = $this->getDoctrine()->getManager();

    $stages = $em->getRepository('AdminBundle:Stage')->findAll();
    return $this->render('FrontBundle::stages.html.twig', array('entities' => $stages));
  }


  public function stageAction($id)
  {
    $query = $this->getDoctrine()->getManager()
    ->createQuery('
    SELECT a FROM AdminBundle:Stage a
    WHERE a.id = :arg
    ')
    ->setParameter('arg', $id);


      $stage =  $query->getSingleResult();

  return $this->render('FrontBundle::stage.html.twig', array('id' => $stage->id));
}


}
