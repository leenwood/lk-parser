<?php

declare(strict_types=1);

namespace App\ParserBundle\Infrastructure\Repository;

use App\ParserBundle\Domain\Entity\VacanciesParseQuery;
use App\ParserBundle\Domain\Repository\VacanciesParseQueryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<VacanciesParseQuery>
 *
 * @method VacanciesParseQuery|null find($id, $lockMode = null, $lockVersion = null)
 * @method VacanciesParseQuery|null findOneBy(array $criteria, array $orderBy = null)
 * @method VacanciesParseQuery[]    findAll()
 * @method VacanciesParseQuery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VacanciesParseQueryRepository extends ServiceEntityRepository implements VacanciesParseQueryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VacanciesParseQuery::class);
    }

    public function save(VacanciesParseQuery $query): void
    {
        $this->_em->persist($query);
        $this->_em->flush();
    }
}