<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use AppBundle\Repository\TranslatableRepository;


class SkipperRepository extends TranslatableRepository
{ 
    /**
     *
     * @return array
     */
    public function findAll()
    {
        $qb = $this->createQueryBuilder('skipper');

        return $this->getResult($qb, 'fr');
    }
}