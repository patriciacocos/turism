<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;

class MonumenteIstoriceRepository extends EntityRepository
{
    public function getMostLikedMonuments(int $limit = 3)
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->select('m.idMonumenteIstorice, count(f.idFavorite) nr_favorites')
            ->join('m.favorites', 'f')
            ->groupBy('m.idMonumenteIstorice')
            ->orderBy('nr_favorites','desc')
            ->setMaxResults($limit);

        return $queryBuilder->getQuery()->execute();
    }
}
