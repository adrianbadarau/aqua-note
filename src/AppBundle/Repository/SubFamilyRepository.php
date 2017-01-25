<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 25-Jan-17
 * Time: 20:31
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class SubFamilyRepository extends EntityRepository
{
    public function getForSelectAllOrderedByName(string $direction = 'ASC')
    {
        return $this->createQueryBuilder('subFamily')
            ->addOrderBy('subFamily.name', $direction);
    }
}