<?php
namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Entity\Stage;
use AdminBundle\Form\StageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Stage controller.
 *
 */
class StageController extends Controller
{
    /**
     * Lists all Stage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $stages = $em->getRepository('AdminBundle:Stage')->findAll();

        return $this->render('stage/index.html.twig', array('stages' => $stages));
    }

    /**
     * Creates a new Stage entity.
     *
     */
    public function newAction(Request $request)
    {
        $stage = new Stage();
        $form = $this->createForm('AdminBundle\Form\StageType', $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();

            return $this->redirectToRoute('stage_show', array('id' => $stage->getId()));
        }

        return $this->render('stage/new.html.twig', array(
            'stage' => $stage,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing Stage entity.
     *
     */
    public function editAction(Request $request, Stage $stage)
    {
        //$deleteForm = $this->createDeleteForm($stage);
        $editForm = $this->createFormBuilder($stage)
                  ->add('titre')
                  ->add('description')
                  ->add('image')
                  ->add('submit', SubmitType::class, array('attr' => array('class' => 'btn sbold green')))
                  ->getForm();
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();

            return $this->redirectToRoute('liste_stages');
        }

        return $this->render('stage/edit.html.twig', array(
            'stage' => $stage,
            'edit_form' => $editForm->createView(),
          //  'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Stage entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
          $em = $this->getDoctrine()->getManager();
          $entity = $em->getRepository('AdminBundle:Stage')->find($id);

          if (!$entity) {
              throw $this->createNotFoundException('Unable to find Stage entity.');
          }

          $em->remove($entity);
          $em->flush();



        return $this->redirectToRoute('liste_stages');
    }


}
