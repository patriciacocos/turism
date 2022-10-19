<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;

class ArtRepository extends EntityRepository
{
    public function getMostLikedArt(int $limit = 3)
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->select('a.idArta, count(f.idFavorite) nr_favorites')
            ->join('a.favorites', 'f')
            ->groupBy('a.idArta')
            ->orderBy('nr_favorites','desc')
            ->setMaxResults($limit);

        return $queryBuilder->getQuery()->execute();
    }
}
