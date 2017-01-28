<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 28-Jan-17
 * Time: 12:22
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class GenusScientist
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="genus_scientist")
 */
class GenusScientist
{
    /**
     * @var $id integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var $genus Genus
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Genus", inversedBy="genusScientists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genus;

    /**
     * @var $user User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="studiedGenuses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var $yearsStudied integer
     * @ORM\Column(type="integer")
     */
    private $yearsStudied;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Genus
     */
    public function getGenus(): Genus
    {
        return $this->genus;
    }

    /**
     * @param Genus $genus
     * @return GenusScientist
     */
    public function setGenus(Genus $genus): GenusScientist
    {
        $this->genus = $genus;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return GenusScientist
     */
    public function setUser(User $user): GenusScientist
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getYearsStudied(): int
    {
        return $this->yearsStudied;
    }

    /**
     * @param int $yearsStudied
     * @return GenusScientist
     */
    public function setYearsStudied(int $yearsStudied): GenusScientist
    {
        $this->yearsStudied = $yearsStudied;
        return $this;
    }



}