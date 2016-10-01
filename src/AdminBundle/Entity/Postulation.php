<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
* Postulation
*
* @ORM\Table(name="postulation")
* @ORM\Entity(repositoryClass="AdminBundle\Repository\PostulationRepository")
*/
class Postulation
{
  /**
  * @var int
  *
  * @ORM\Column(name="id", type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;

  /**
  * @var string
  *
  * @ORM\Column(name="nom", type="string", length=255)
  */
  private $nom;

  /**
  * @var string
  *
  * @ORM\Column(name="email", type="string", length=255)
  */

  private $email;

  /**
  * @var string
  *
  * @ORM\Column(name="commentaire", type="text")
  */
  private $commentaire;

  /**
  * @var string
  *
  * @ORM\Column(name="cv", type="string")
  * @Assert\NotBlank(message="Please, upload your cv as a PDF file.")
  * @Assert\File(mimeTypes={ "application/pdf" })
  */
  private $cv;


  /**
  * Get id
  *
  * @return int
  */
  public function getId()
  {
    return $this->id;
  }

  /**
  * Set nom
  *
  * @param string $nom
  *
  * @return String
  */
  public function setNom($nom)
  {
    $this->nom = $nom;

    return $this;
  }

  /**
  * Get nom
  *
  * @return string
  */
  public function getNom()
  {
    return $this->nom;
  }

  /**
  * Set commentaire
  *
  * @param string $commentaire
  *
  * @return Commentaire
  */
  public function setCommentaire($commentaire)
  {
    $this->commentaire = $commentaire;

    return $this;
  }

  /**
  * Get commentaire
  *
  * @return string
  */
  public function getCommentaire()
  {
    return $this->commentaire;
  }

  /**
  * Set cv
  *
  * @param string $cv
  *
  * @return Stage
  */
  public function setCv($cv)
  {
    $this->cv = $cv;

    return $this;
  }

  /**
  * Get cv
  *
  * @return string
  */
  public function getCv()
  {
    return $this->cv;
  }

  /**
  * Set email
  *
  * @param string $nomemail
  *
  * @return String
  */
  public function setEmail($email)
  {
    $this->email = $email;

    return $this;
  }

  /**
  * Get email
  *
  * @return string
  */
  public function getEmail()
  {
    return $this->email;
  }
}
