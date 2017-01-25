<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Genus;
use AppBundle\Form\GenusFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class GenusAdminController extends Controller
{
    /**
     * @Route("/genus", name="admin_genus_list")
     */
    public function indexAction()
    {
        $genuses = $this->getDoctrine()
            ->getRepository('AppBundle:Genus')
            ->findAll();

        return $this->render('AppBundle:admin/genus:list.html.twig', array(
            'genuses' => $genuses
        ));
    }

    /**
     * @Route("/genus/new", name="admin_genus_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(GenusFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $genus = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($genus);
            $em->flush();
            $this->addFlash('success', 'Genus successfully created');
            return $this->redirectToRoute('admin_genus_list');
        }
        return $this->render('AppBundle:admin/genus:new.html.twig', [
            'genusForm' => $form->createView(),
            'type' => 'New'
        ]);
    }

    /**
     * @Route("/genus/{id}/edit", name="admin_genus_edit")
     * @param Genus $genus
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request,Genus $genus)
    {
        $form = $this->createForm(GenusFormType::class, $genus);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $genus = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($genus);
            $em->flush();
            $this->addFlash('success', 'Genus successfully edited');
            return $this->redirectToRoute('admin_genus_list');
        }
        return $this->render('AppBundle:admin/genus:new.html.twig',[
            'genus' => $genus,
            'genusForm' => $form->createView(),
            'type' => 'Edit'
        ]);
    }
}