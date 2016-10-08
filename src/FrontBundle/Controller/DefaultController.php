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


    public function galerieAction()
    {
      return $this->render('FrontBundle::galerie.html.twig');
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

      $em = $this->getDoctrine()->getManager();
      $stage = $em->getRepository('AdminBundle:Stage')->find($id);

      $body=
            "\n\n\n ***** INFORMATION SUR LES CHAMPS DU FORMULAIRE ***** ".
            "\n Stage ID : ".$id.
            "\n Titre du stage : ".$stage->getTitre().
            "\n\n\n ***** INFORMATION SUR L'ETUDIANT ***** ".
            "\n nom : ".$form_postuler["nom"]->getData().
            "\n email : ".$form_postuler["email"]->getData().
            "\n commentaire : ".$form_postuler["commentaire"]->getData();

      $message = \Swift_Message::newInstance()
      ->setSubject("Demande pour l'offre de stage : ".$stage->getTitre())
      ->setFrom('iskanderjaiem@gmail.com')
      ->setTo('iskander.jaiem@esprit.tn')
      ->setBody($body)
      ->attach(\Swift_Attachment::fromPath('file/'.$file->getClientOriginalName()));
      $this->get('mailer')->send($message);

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

  public function adhesionAction(Request $request)
  {

        if ($request->query->get('nom')!=null && $request->query->get('email')!=null  && $request->query->get('tel')!=null /*&& $form->isValid()*/) {

          $nom = $request->query->get('nom');
          $email =$request->query->get('email');
          $tel =$request->query->get('tel');
          $ad =$request->query->get('adhesion');

          $body=
                "\n\n\n ***** INFORMATION SUR LES CHAMPS DU FORMULAIRE ***** ".
                "\n Nom et prénom : ".$nom.
                "\n Adresse Email: ".$email.
                "\n Numéro de Tél: ".$tel.
                "\n Type d'adhésion: ".$ad." Euros";

          $message = \Swift_Message::newInstance()
          ->setSubject("Demande d'adhésion : ".$nom)
          ->setFrom('iskanderjaiem@gmail.com')
          ->setTo('iskander.jaiem@esprit.tn')
          ->setBody($body);
          $this->get('mailer')->send($message);

          return $this->render('FrontBundle::merci.html.twig');
      }
        $em = $this->getDoctrine()->getManager();
        $stages = $em->getRepository('AdminBundle:Stage')->findAll();
        return $this->render('FrontBundle::index.html.twig', array('entities' => $stages));
    }




}
