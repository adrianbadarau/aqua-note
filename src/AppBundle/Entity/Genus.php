<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Genus
 *
 * @ORM\Table(name="genus")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GenusRepository")
 */
class Genus
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var $name string
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SubFamily")
     * @ORM\JoinColumn(nullable=true)
     */
    private $subFamily;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(min="0",minMessage="Please insert only positives")
     */
    private $speciesCount;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $funFact;

    /**
     * @var $isPublished boolean
     *
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $isPublished = false;

    /**
     * @var $notes GenusNote[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\GenusNote", mappedBy="genus")
     * @ORM\OrderBy({"createdAt"="DESC"})
     */
    private $notes;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    private $firstDiscoveredAt;

    /**
     * @var $created \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @var $updated \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @var User[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="studiedGenuses" )
     */
    private $genusScientists;

    /**
     * Genus constructor.
     */
    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->genusScientists = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Genus
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return SubFamily
     */
    public function getSubFamily()
    {
        return $this->subFamily;
    }

    /**
     * @param SubFamily $subFamily
     * @return $this
     */
    public function setSubFamily(SubFamily $subFamily = null)
    {
        $this->subFamily = $subFamily;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpeciesCount()
    {
        return $this->speciesCount;
    }

    /**
     * @param mixed $speciesCount
     */
    public function setSpeciesCount($speciesCount)
    {
        $this->speciesCount = $speciesCount;
    }

    /**
     * @return mixed
     */
    public function getFunFact()
    {
        return $this->funFact;
    }

    /**
     * @param mixed $funFact
     */
    public function setFunFact($funFact)
    {
        $this->funFact = $funFact;
    }

    public function getUpdatedAt()
    {
        return new \DateTime("-".rand(0,10)." days");
    }

    /**
     * @return bool
     */
    public function isIsPublished(): bool
    {
        return $this->isPublished;
    }

    /**
     * @param bool $isPublished
     */
    public function setIsPublished(bool $isPublished)
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return ArrayCollection|GenusNote[]
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @return \DateTime
     */
    public function getFirstDiscoveredAt()
    {
        return $this->firstDiscoveredAt;
    }

    /**
     * @param \DateTime $firstDiscoveredAt
     */
    public function setFirstDiscoveredAt(\DateTime $firstDiscoveredAt = null)
    {
        $this->firstDiscoveredAt = $firstDiscoveredAt;
    }



    /**
     * Get isPublished
     *
     * @return boolean
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Add note
     *
     * @param \AppBundle\Entity\GenusNote $note
     *
     * @return Genus
     */
    public function addNote(\AppBundle\Entity\GenusNote $note)
    {
        $this->notes[] = $note;

        return $this;
    }

    /**
     * Remove note
     *
     * @param \AppBundle\Entity\GenusNote $note
     */
    public function removeNote(\AppBundle\Entity\GenusNote $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * @return mixed
     */
    public function getSlug() :string
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return \DateTime
     */
    public function getCreated() : \DateTime
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated() : \DateTime
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return User[]|ArrayCollection
     */
    public function getGenusScientists()
    {
        return $this->genusScientists;
    }

    /**
     * @param User[] $genusScientists
     * @return void
     */
    public function setGenusScientists(array $genusScientists) : void
    {
        $this->genusScientists = $genusScientists;
    }

    public function addGenusScientist(User $user) : void
    {
        if($this->genusScientists->contains($user)){
            return;
        }
        $this->genusScientists->add($user);
    }

    public function removeGenusScientist(User $user) : void
    {
        $this->getGenusScientists()->removeElement($user);
    }
}
