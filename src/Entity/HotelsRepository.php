<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;

class HotelsRepository extends EntityRepository
{
    public function getMostLikedHotels(int $limit = 3)
    {
        $queryBuilder = $this->createQueryBuilder('h')
            ->select('h.idCazare, count(f.idFavorite) nr_favorites')
            ->join('h.favorites', 'f')
            ->groupBy('h.idCazare')
            ->orderBy('nr_favorites','desc')
            ->setMaxResults($limit);

        return $queryBuilder->getQuery()->execute();
    }
}
