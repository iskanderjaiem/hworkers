<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
  public function indexAction()
  {
      return $this->render('FrontBundle::index.html.twig');
  }
  public function fondateursAction()
  {
      return $this->render('FrontBundle::fondateurs.html.twig');
  }
  public function etudiantAction()
  {
      return $this->render('FrontBundle::etudiant.html.twig');
  }
  public function professionnelAction()
  {
      return $this->render('FrontBundle::professionnel.html.twig');
  }
  public function nousSoutenirAction()
  {
      return $this->render('FrontBundle::nous_soutenir.html.twig');
  }
  public function nousContacterAction()
  {
      return $this->render('FrontBundle::nous_contacter.html.twig');
  }


}
