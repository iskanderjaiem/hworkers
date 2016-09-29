<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AdminBundle\Entity\Stage;
use AdminBundle\Form\StageType;

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
     * Finds and displays a Stage entity.
     *
     */
    public function showAction(Stage $stage)
    {

        return $this->render('stage/show.html.twig', array(
            'stage' => $stage));
    }

    /**
     * Displays a form to edit an existing Stage entity.
     *
     */
    public function editAction(Request $request, Stage $stage)
    {
        $deleteForm = $this->createDeleteForm($stage);
        $editForm = $this->createForm('AdminBundle\Form\StageType', $stage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();

            return $this->redirectToRoute('stage_edit', array('id' => $stage->getId()));
        }

        return $this->render('stage/edit.html.twig', array(
            'stage' => $stage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Stage entity.
     *
     */
    public function deleteAction(Request $request, Stage $stage)
    {
        $form = $this->createDeleteForm($stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stage);
            $em->flush();
        }

        return $this->redirectToRoute('stage_index');
    }

    /**
     * Creates a form to delete a Stage entity.
     *
     * @param Stage $stage The Stage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Stage $stage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stage_delete', array('id' => $stage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
