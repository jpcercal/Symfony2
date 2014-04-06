<?php

namespace Cekurte\Pages\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cekurte\GeneratorBundle\Controller\CekurteController;
use Cekurte\GeneratorBundle\Controller\RepositoryInterface;
use Cekurte\GeneratorBundle\Office\PHPExcel as CekurtePHPExcel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Cekurte\Pages\CoreBundle\Entity\Page;
use Cekurte\Pages\CoreBundle\Entity\Repository\PageRepository;
use Cekurte\Pages\AdminBundle\Form\Type\PageFormType;
use Cekurte\Pages\AdminBundle\Form\Handler\PageFormHandler;

/**
 * Page controller.
 *
 * @Route("/page")
 *
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 0.1
 */
class PageController extends CekurteController implements RepositoryInterface
{
    /**
     * Get a instance of PageRepository.
     *
     * @return PageRepository
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function getEntityRepository()
    {
        return $this->get('doctrine')->getRepository('CekurtePagesCoreBundle:Page');
    }

    /**
     * Lists all Page entities.
     *
     * @Route("/", defaults={"page"=1, "sort"="ck.id", "direction"="asc"}, name="page")
     * @Route("/page/{page}/sort/{sort}/direction/{direction}/", defaults={"page"=1, "sort"="ck.id", "direction"="asc"}, name="page_paginator")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_CEKURTEPAGESADMINBUNDLE_PAGE, ROLE_ADMIN")
     *
     * @param int $page
     * @param string $sort
     * @param string $direction
     * @return array
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function indexAction($page, $sort, $direction)
    {
        $form = $this->createForm(new PageFormType(), new Page(), array(
            'search' => true,
        ));

        if ($this->get('session')->has('search_page')) {

            $form->bind($this->get('session')->get('search_page'));
        }

        $query = $this->getEntityRepository()->getQuery($form->getData(), $sort, $direction);

        $pagination = $this->getPagination($query, $page);

        $pagination->setUsedRoute('page_paginator');

        return array(
            'pagination'    => $pagination,
            'delete_form'   => $this->createDeleteForm()->createView(),
            'search_form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to search a Page entity.
     *
     * @Route("/search", name="page_search")
     * @Method({"GET", "POST"})
     * @Template()
     * @Secure(roles="ROLE_CEKURTEPAGESADMINBUNDLE_PAGE, ROLE_ADMIN")
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function searchAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->get('session')->set('search_page', $request);
        } else {
            $this->get('session')->remove('search_page');
        }

        return $this->redirect($this->generateUrl('page'));
    }

    /**
     * Export Page entities to Excel.
     *
     * @Route("/export/sort/{sort}/direction/{direction}/", defaults={"sort"="ck.id", "direction"="asc"}, name="page_export")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_CEKURTEPAGESADMINBUNDLE_PAGE, ROLE_ADMIN")
     *
     * @param string $sort
     * @param string $direction
     * @return StreamedResponse
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function exportAction($sort, $direction)
    {
        $form = $this->createForm(new PageFormType(), new Page(), array(
            'search' => true,
        ));

        if ($this->get('session')->has('search_page')) {

            $form->bind($this->get('session')->get('search_page'));
        }

        $query = $this->getEntityRepository()->getQuery($form->getData(), $sort, $direction);

        $office = new CekurtePHPExcel('Relatório de Pages');

        $office
            ->setHeader(array(
                'id' => 'id',
                'slug' => 'slug',
                'image' => 'image',
                'title' => 'title',
                'abstract' => 'abstract',
                'description' => 'description',
                'date' => 'date',
                'active' => 'active',
            ))
            ->setData($query->getArrayResult())
            ->build()
        ;

        return $office->createResponse();
    }

    /**
     * Creates a new Page entity.
     *
     * @Route("/", name="page_create")
     * @Method("POST")
     * @Template("CekurtePagesCoreBundle:Page:new.html.twig")
     * @Secure(roles="ROLE_CEKURTEPAGESADMINBUNDLE_PAGE_CREATE, ROLE_ADMIN")
     *
     * @param Request $request
     * @return array|RedirectResponse
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new PageFormType(), new Page());

        $handler = new PageFormHandler(
            $form,
            $this->getRequest(),
            $this->get('doctrine')->getManager(),
            $this->get('session')->getFlashBag()
        );

        if ($id = $handler->save()) {
            return $this->redirect($this->generateUrl('page_show', array('id' => $id)));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Page entity.
     *
     * @Route("/new", name="page_new")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_CEKURTEPAGESADMINBUNDLE_PAGE_CREATE, ROLE_ADMIN")
     *
     * @return array|Response
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function newAction()
    {
        $form = $this->createForm(new PageFormType(), new Page());

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Page entity.
     *
     * @Route("/{id}", name="page_show")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_CEKURTEPAGESADMINBUNDLE_PAGE_RETRIEVE, ROLE_ADMIN")
     *
     * @param int $id
     * @return array|Response
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function showAction($id)
    {
        $entity = $this->getEntityRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $this->createDeleteForm()->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("/{id}/edit", name="page_edit")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_CEKURTEPAGESADMINBUNDLE_PAGE_UPDATE, ROLE_ADMIN")
     *
     * @param int $id
     * @return array|Response
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function editAction($id)
    {
        $entity = $this->getEntityRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $editForm = $this->createForm(new PageFormType(), $entity);

        return array(
            'entity'      => $entity,
            'page_image'  => $editForm->get('image')->getData(),
            'edit_form'   => $editForm->createView(),
            'delete_form' => $this->createDeleteForm()->createView(),
        );
    }

    /**
     * Edits an existing Page entity.
     *
     * @Route("/{id}", name="page_update")
     * @Method("PUT")
     * @Template("CekurtePagesAdminBundle:Page:edit.html.twig")
     * @Secure(roles="ROLE_CEKURTEPAGESADMINBUNDLE_PAGE_UPDATE, ROLE_ADMIN")
     *
     * @param Request $request
     * @param int $id
     * @return array|Response
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->getEntityRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $form = $this->createForm(new PageFormType(), $entity);

        $handler = new PageFormHandler(
            $form,
            $request,
            $this->get('doctrine')->getManager(),
            $this->get('session')->getFlashBag()
        );

        if ($id = $handler->save()) {
            return $this->redirect($this->generateUrl('page_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'page_image'  => $form->get('image')->getData(),
            'edit_form'   => $form->createView(),
            'delete_form' => $this->createDeleteForm()->createView(),
        );
    }

    /**
     * Deletes a Page entity.
     *
     * @Route("/{id}", name="page_delete")
     * @Method("DELETE")
     * @Secure(roles="ROLE_CEKURTEPAGESADMINBUNDLE_PAGE_DELETE, ROLE_ADMIN")
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function deleteAction(Request $request, $id)
    {
        $handler = new PageFormHandler(
            $this->createDeleteForm(),
            $request,
            $this->get('doctrine')->getManager(),
            $this->get('session')->getFlashBag()
        );

        if ($handler->delete('CekurtePagesCoreBundle:Page')) {
            return $this->redirect($this->generateUrl('page'));
        } else {
            return $this->redirect($this->generateUrl('page_show', array('id' => $id)));
        }
    }
}
