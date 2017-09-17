<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genre;
use AppBundle\Entity\Manga;
use AppBundle\Entity\User;
use AppBundle\Entity\Volume;
use AppBundle\Form\VolumeType;
//use Symfony\Bridge\Doctrine\Tests\Fixtures\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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

        $user = $this->getUser();

        if($this->isGranted('IS_AUTHENTICATED_FULLY')) {
           $mangas = $em->getRepository('AppBundle:Manga')->findByUser($user);
        }
        else{
            $mangas = $em->getRepository('AppBundle:Manga')->findAll();
        }



        return $this->render('manga/index.html.twig', array(
            'mangas' => $mangas,
        ));
    }

    /**
     * Creates a new manga entity.
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
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

            $manga->addUser($this->getUser());
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
     * @Route("/manga/all", name="manga_all_index")
     * @Method({"GET", "POST"})
     */
    public function allIndexAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Manga::class);
        $mangas = $repository->findAll();

        return $this->render('manga/index.html.twig', array(
            'mangas' => $mangas,
        ));
    }
    /**
     * Displays a form to edit an existing manga entity.
     *
     * @Route("/{id}/edit", name="manga_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', manga)")
     */
    public function editAction(Request $request, Manga $manga)
    {
        #$this->denyAccessUnlessGranted('edit',$manga);

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
     * @Security("is_granted('edit', manga)")
     */
    public function deleteAction(Request $request, Manga $manga)
    {
        $form = $this->createDeleteForm($manga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $manga->setUser(null);
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
     *
     */
    private function createDeleteForm(Manga $manga)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manga_delete', array('id' => $manga->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * @Route("/volume/{id}/new", name="volume_new")
     * @Method("POST")
     * @Security("is_granted('edit', manga)")
     * @ParamConverter("manga", class="AppBundle:Manga")
     *
     * Method adds new volume to manga
     */
    public function volumeNewAction(Request $request,$manga){

        $volume = new Volume();


        $form = $this->createForm(VolumeType::class,$volume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $manga->addVolume($volume);

            $em->persist($volume);
            $em->flush();

            return $this->redirectToRoute("manga_show",['id' => $manga->getId()]);
        }

        return $this->render("manga/volume_form_error.html.twig",[
            'manga' => $manga,
            'form' => $form->createView(),
        ]);

    }
    /**
    *
    * @param Manga $manga
    *
    * @return Response
    */
    public function volumeFormAction(Manga $manga)
    {
        $form = $this->createForm(VolumeType::class);
        return $this->render('manga/_volume_form.html.twig', [
            'manga' => $manga,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Manga $manga
     * @param Volume $volume
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function volumeShowAction(Request $request,Manga $manga,Volume $volume)
    {
        $deleteForm = $this->createVolumeDeleteForm($volume);
        return $this->render('manga/_volume_card.html.twig',[
           'volume_delete_form' => $deleteForm->createView(),
            'manga' => $manga,
            'volume' =>$volume
        ]);
    }
    /**
     * Deletes a volume entity.
     *
     * @Route("/volume/{id}", name="volume_delete")
     * @Method("DELETE")
     * @Security("is_granted('edit', manga)")
     */
    public function deleteVolumeAction(Request $request, Volume $volume)
    {
        $form = $this->createVolumeDeleteForm($volume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($volume);
            $em->flush();
        }

        return $this->redirectToRoute('manga_index');
    }

    /**
     * @param Volume $volume
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function createVolumeDeleteForm(Volume $volume)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('volume_delete', array('id' => $volume->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
