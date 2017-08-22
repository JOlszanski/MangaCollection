<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genre;
use AppBundle\Entity\Manga;
use AppBundle\Entity\Volume;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Manga controller.
 *
 * @Route("manga")
 */
class MangaController extends Controller
{
    /**
     * Lists all manga entities.
     *
     * @Route("/", name="manga_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $mangas = $em->getRepository('AppBundle:Manga')->findAll();

        return $this->render('manga/index.html.twig', array(
            'mangas' => $mangas,
        ));
    }

    /**
     * Creates a new manga entity.
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/new", name="manga_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $manga = new Manga();
        $form = $this->createForm('AppBundle\Form\MangaType', $manga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($manga);
            $em->flush();

            return $this->redirectToRoute('manga_show', array('id' => $manga->getId()));
        }

        return $this->render('manga/new.html.twig', array(
            'manga' => $manga,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a manga entity.
     *
     * @Route("/{id}", name="manga_show")
     * @Method("GET")
     */
    public function showAction(Manga $manga)
    {
        $deleteForm = $this->createDeleteForm($manga);

        $repository = $this->getDoctrine()->getRepository(Volume::class);
        $volumes = $repository->findByManga($manga);

        return $this->render('manga/show.html.twig', array(
            'manga' => $manga,
            'delete_form' => $deleteForm->createView(),
            'volumes' => $volumes,
        ));
    }

    /**
     * Displays a form to edit an existing manga entity.
     *
     * @Route("/{id}/edit", name="manga_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Manga $manga)
    {
        $deleteForm = $this->createDeleteForm($manga);
        $editForm = $this->createForm('AppBundle\Form\MangaType', $manga);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()){

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('manga_edit', array('id' => $manga->getId()));
        }

        return $this->render('manga/edit.html.twig', array(
            'manga' => $manga,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a manga entity.
     *
     * @Route("/{id}", name="manga_delete")
     * @Method("DELETE")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Manga $manga)
    {
        $form = $this->createDeleteForm($manga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($manga);
            $em->flush();
        }

        return $this->redirectToRoute('manga_index');
    }

    /**
     * Creates a form to delete a manga entity.
     *
     * @param Manga $manga The manga entity
     *
     * @return \Symfony\Component\Form\Form The form
     * @Security("is_granted('ROLE_ADMIN')")
     */
    private function createDeleteForm(Manga $manga)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manga_delete', array('id' => $manga->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
