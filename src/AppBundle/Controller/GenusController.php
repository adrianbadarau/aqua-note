<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GenusController extends Controller
{
    /**
     * @Route("/genus/{name}")
     * @param string $name
     * @return Response
     */
    public function showAction(string $name)
    {
        $notes = [
            'Lorem ipsum dolor sit amet, ne tantas dolorem quaestio quo, in vix choro principes torquatos. Eu qui iuvaret mentitum conclusionemque, quem laudem sententiae sea et. Eligendi ponderum dissentias ut cum, eu timeam audire scribentur ius! Eu eum veniam salutatus constituam. Omnesque petentium complectitur id sit. Vim reque saepe te, no nec natum persius.',
            'Lorem ipsum dolor sit amet, ne tantas dolorem quaestio quo, in vix choro principes torquatos. Eu qui iuvaret mentitum conclusionemque, quem laudem sententiae sea et. Eligendi ponderum dissentias ut cum, eu timeam audire scribentur ius! Eu eum veniam salutatus constituam. Omnesque petentium complectitur id sit. Vim reque saepe te, no nec natum persius.',
            'Lorem ipsum dolor sit amet, ne tantas dolorem quaestio quo, in vix choro principes torquatos. Eu qui iuvaret mentitum conclusionemque, quem laudem sententiae sea et. Eligendi ponderum dissentias ut cum, eu timeam audire scribentur ius! Eu eum veniam salutatus constituam. Omnesque petentium complectitur id sit. Vim reque saepe te, no nec natum persius.'
        ];
        return $this->render("@App/genus/show.html.twig",compact('name', 'notes'));
    }
}
