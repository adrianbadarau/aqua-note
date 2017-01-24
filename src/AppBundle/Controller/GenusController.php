<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GenusController extends Controller
{

    /**
     * @Route("/genus/new", name="genus_new")
     * @Method("POST")
     **/
    public function newAction()
    {
        $genus = new Genus();
        $genus->setName('Octopus'.rand(0,100));
        $genus->setSpeciesCount(rand(1,10000));
        $genus->setSubFamiliy('Octopodinae');
        $genus->setIsPublished(true);

        $note = new GenusNote();
        $note->setUsername('AquaWeaver');
        $note->setUserAvatarFilename('ryan.jpeg');
        $note->setNote('I counted 8 legs... as they wrapped around me');
        $note->setCreatedAt(new \DateTime('-1 month'));
        $note->setGenus($genus);

        $em = $this->getDoctrine()->getManager();
        $em->persist($genus);
        $em->persist($note);
        $em->flush();

        return new Response("Genus created");
    }

    /**
     * @Route("/genus", name="genus_list")
    **/
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $genusRepository = $em->getRepository("AppBundle:Genus");
        $genuses = $genusRepository->findAllPublishedOrderedBySize();

        return $this->render("AppBundle:genus:list.html.twig",[
            'genuses' => $genuses,
        ]);
    }

    /**
     * @Route("/genus/{name}", name="genus_show")
     * @param string $name
     * @return Response
     */
    public function showAction(string $name)
    {
        $em = $this->getDoctrine()->getManager();
        $genusRepository = $em->getRepository("AppBundle:Genus");

        $genus = $genusRepository->findOneBy(['name' => $name]);

        if(!$genus){
            throw $this->createNotFoundException('Genus not found');
        }
        $funFact = "Octopuses can change the color of their body in just *three-tenths* of a second!";
        $cache = $this->get('doctrine_cache.providers.my_markdown_cache');
        $key = md5($funFact);
        if ($cache->contains($key)) {
            $funFact = $cache->fetch($key);
        } else {
            $mdParser = $this->get('markdown.parser');
            $funFact = $mdParser->transform($funFact);
            $cache->save($key,$funFact);
        }


        return $this->render("@App/genus/show.html.twig", [
            'genus' => $genus,
            'funFact' => $funFact
        ]);
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
