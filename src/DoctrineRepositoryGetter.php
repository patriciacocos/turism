<?php

declare(strict_types=1);

namespace App;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;

final class DoctrineRepositoryGetter
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    public function getRepository(string $className): ObjectRepository
    {
        return $this->doctrine->getManager()->getRepository($className);
    }
}
