<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;

class RestaurantCafeRepository extends EntityRepository
{
    public function getMostLikedRestaurants(int $limit = 3)
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r.idMancareBautura, count(f.idFavorite) nr_favorites')
            ->join('r.favorites', 'f')
            ->groupBy('r.idMancareBautura')
            ->orderBy('nr_favorites','desc')
            ->setMaxResults($limit);

        return $queryBuilder->getQuery()->execute();
    }
}
