<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository for the Wish entity.
 *
 * @extends ServiceEntityRepository<Wish>
 *
 * @method Wish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wish[]    findAll()
 * @method Wish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }

    /**
     * Retrieves the last ideas.
     *
     * This function uses QueryBuilder to build the query.
     *
     * @return Wish[] An array of Wish objects representing the ideas.
     */
    public function findAllIdeas()
    {
        // Create a QueryBuilder to build the query.
        $queryBuilder = $this->createQueryBuilder('w');

        // Add conditions to select the last ideas.
        $queryBuilder->select('w');
        $queryBuilder->addOrderBy('w.dateCreated', 'DESC');

        // Create the query from the QueryBuilder.
        $query = $queryBuilder->getQuery();

        // Execute the query and return the results.
        $results = $query->getResult();
        dump($results); // DEBUG

        return $results;
    }
}
