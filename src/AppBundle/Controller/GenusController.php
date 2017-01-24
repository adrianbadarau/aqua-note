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
        $genuses = $genusRepository->findAllOrderedByRecentNote();

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

        $newNotes = $this->getDoctrine()->getRepository("AppBundle:GenusNote")->findAllRecentNotesForGenus($genus);

        $genus->setFunFact(
            $this->get('app.markdown_transformer')->parse($genus->getFunFact())
        );
//        $funFact = "Octopuses can change the color of their body in just *three-tenths* of a second!";
//        $cache = $this->get('doctrine_cache.providers.my_markdown_cache');
//        $key = md5($funFact);
//        if ($cache->contains($key)) {
//            $funFact = $cache->fetch($key);
//        } else {
//            $mdParser = $this->get('markdown.parser');
//            $funFact = $mdParser->transform($funFact);
//            $cache->save($key,$funFact);
//        }


        return $this->render("@App/genus/show.html.twig", [
            'genus' => $genus,
            'recentNotesCount' => count($newNotes)
        ]);
    }

    /**
     * @Route("/genus/{name}/notes", name="genus_show_notes")
     * @Method("GET")
     * @param Genus $genus
     * @return JsonResponse
     */
    public function getNotesAction(Genus $genus)
    {
        $notes = [];
        foreach ($genus->getNotes() as $note){
            $notes[] = [
                'id' => $note->getId(),
                'username' => $note->getUsername(),
                'avatarUri' => '/images/'.$note->getUserAvatarFilename(),
                'note' => $note->getNote(),
                'date' => $note->getCreatedAt()->format('M d, Y')
            ];
        }
        $data = [
            'notes' => $notes
        ];

        return new JsonResponse($data);
    }



}
