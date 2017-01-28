<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use AppBundle\Entity\GenusScientist;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
        $em = $this->getDoctrine()->getManager();

        $genus = new Genus();
        $genus->setName('Octopus' . rand(0, 100));
        $genus->setSpeciesCount(rand(1, 10000));
        $genus->setIsPublished(true);
        $genus->setFirstDiscoveredAt(new \DateTime());

        $note = new GenusNote();
        $note->setUsername('AquaWeaver');
        $note->setUserAvatarFilename('ryan.jpeg');
        $note->setNote('I counted 8 legs... as they wrapped around me');
        $note->setCreatedAt(new \DateTime('-1 month'));
        $note->setGenus($genus);

        $user1 = $em->getRepository("AppBundle:User")->findOneBy(['email' => 'aquanaut1@example.org']);
        $user2 = $em->getRepository("AppBundle:User")->findOneBy(['email' => 'aquanaut2@example.org']);

        $genusScientist = new GenusScientist();
        $genusScientist->setGenus($genus)->setUser($user1)->setYearsStudied(10);

        $em->persist($genus);
        $em->persist($note);
        $em->persist($genusScientist);
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

        return $this->render("AppBundle:genus:list.html.twig", [
            'genuses' => $genuses,
        ]);
    }

    /**
     * @Route("/genus/{slug}", name="genus_show")
     * @param Genus $genus
     * @return Response
     * @internal param string $name
     */
    public function showAction(Genus $genus)
    {

        $newNotes = $this->getDoctrine()->getRepository("AppBundle:GenusNote")->findAllRecentNotesForGenus($genus);

        $genus->setFunFact(
            $this->get('app.markdown_transformer')->parse($genus->getFunFact())
        );

        return $this->render("@App/genus/show.html.twig", [
            'genus' => $genus,
            'recentNotesCount' => count($newNotes)
        ]);
    }

    /**
     * @Route("/genus/{slug}/notes", name="genus_show_notes")
     * @Method("GET")
     * @param Genus $genus
     * @return JsonResponse
     */
    public function getNotesAction(Genus $genus)
    {
        $notes = [];
        foreach ($genus->getNotes() as $note) {
            $notes[] = [
                'id' => $note->getId(),
                'username' => $note->getUsername(),
                'avatarUri' => '/images/' . $note->getUserAvatarFilename(),
                'note' => $note->getNote(),
                'date' => $note->getCreatedAt()->format('M d, Y')
            ];
        }
        $data = [
            'notes' => $notes
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/genus/{genus_id}/scientist/{user_id}", name="genus_scientist_remove")
     * @ParamConverter("genusScientist", options={"mapping":{"genus_id":"genus","user_id":"user"}},class="AppBundle:GenusScientist")
     * @Method("DELETE")
     * @param GenusScientist $genusScientist
     * @return JsonResponse
     */
    public function removeScientistAction(GenusScientist $genusScientist)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($genusScientist);
        $em->flush();
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }


}
