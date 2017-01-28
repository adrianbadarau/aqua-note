<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
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

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find(11);
        $genus->addGenusScientist($user);
        $user = $em->getRepository('AppBundle:User')->find(12);
        $genus->addGenusScientist($user);
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
     * @ParamConverter("genus", options={"mapping":{"genus_id":"id"}},class="AppBundle:Genus")
     * @ParamConverter("user", options={"mapping":{"user_id":"id"}}, class="AppBundle:User")
     * @Method("DELETE")
     * @param Genus $genus
     * @param User $user
     * @return JsonResponse
     */
    public function removeScientistAction(Genus $genus, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $genus->removeGenusScientist($user);
        $em->persist($user);
        $em->flush();
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }


}
