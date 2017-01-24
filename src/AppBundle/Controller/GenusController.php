<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    /**
     * @Route("/genus/{name}/notes", name="genus_show_notes")
     * @Method("GET")
     * @param string $name
     * @return JsonResponse
     */
    public function getNotesAction(string $name)
    {
        $notes = [
            ['id' => 1, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Octopus asked me a riddle, outsmarted me', 'date' => 'Dec. 10, 2015'],
            ['id' => 2, 'username' => 'AquaWeaver', 'avatarUri' => '/images/ryan.jpeg', 'note' => 'I counted 8 legs... as they wrapped around me', 'date' => 'Dec. 1, 2015'],
            ['id' => 3, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Inked!', 'date' => 'Aug. 20, 2015'],
        ];
        $data = [
            'notes' => $notes
        ];

        return new JsonResponse($data);
    }
}
