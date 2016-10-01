<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Entity\Postulation;
use AdminBundle\Form\PostulationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class DefaultController extends Controller
{
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $stages = $em->getRepository('AdminBundle:Stage')->findAll();
    return $this->render('FrontBundle::index.html.twig', array('entities' => $stages));
  }

  public function stagesAction()
  {
    $em = $this->getDoctrine()->getManager();
    $stages = $em->getRepository('AdminBundle:Stage')->findAll();
    return $this->render('FrontBundle::stages.html.twig', array('entities' => $stages));
  }


  public function stageAction(Request $request, $id)
  {

    $postulation = new Postulation();
    $form_postuler = $this->createFormBuilder($postulation)
        ->add('nom')
        ->add('email')
        ->add('cv', FileType::class, array('label' => '(PDF file)'))
        ->add('commentaire')
        ->add('postuler', SubmitType::class, array('attr' => array('class' => 'btn sbold green')))
        ->getForm();
    $form_postuler->handleRequest($request);

    if ($form_postuler->isSubmitted() && $form_postuler->isValid()) {
      $file = $form_postuler['cv']->getData();
      $file->move('file', $file->getClientOriginalName());
      $em = $this->getDoctrine()->getManager();
      //$postulation->setCv($file->getClientOriginalName());
      $em->persist($postulation);
      $em->flush();

      $body="\n\n Stage ID : ".$id.
            "\n nom : ".$form_postuler["nom"]->getData().
            "\n email : ".$form_postuler["email"]->getData().
            "\n cv : ".$form_postuler["cv"]->getData().
            "\n commentaire : ".$form_postuler["commentaire"]->getData();

      $message = \Swift_Message::newInstance()
      ->setSubject('Stage N x')
      ->setFrom('hworker.sender@gmail.com')
      ->setTo('iskander.jaiem@esprit.tn')
      ->setBody($body)
      ->attach(\Swift_Attachment::fromPath('file/'.$file->getClientOriginalName()));
      //$this->get('mailer')->send($message);

      return $this->render('FrontBundle::merci.html.twig');
    }

    $query = $this->getDoctrine()->getManager()
    ->createQuery('
    SELECT a FROM AdminBundle:Stage a
    WHERE a.id = :arg
    ')
    ->setParameter('arg', $id);
    $stage =  $query->getSingleResult();
    return $this->render('FrontBundle::stage.html.twig', array('stage' => $stage,'form_postuler'=>$form_postuler->createView()));
  }



}
