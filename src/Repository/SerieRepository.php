<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
//commentaire aide à l'auto-completion, a laiddé !!
class SerieRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Serie::class);
	}

	public function findBestSeries()
	{
		//requête DQL
		/*$entityManager = $this->getEntityManager(); //appel de la méthode car pas injectable ici
		$dql = " select serie from App\Entity\Serie serie
 			where serie.popularity>100
 			and serie.vote>8 
 			ORDER BY serie.popularity DESC"; // création de la requete en mode DQL requête
		// création objet query à partir de la requête
		$query = $entityManager->createQuery($dql);
		*/

		//requête QueryBuilder
		$queryBuilder = $this->createQueryBuilder('serie');
				$queryBuilder->andWhere('serie.popularity > 100');
				$queryBuilder->andWhere('serie.vote >8');
				$queryBuilder->addorderBy('serie.popularity', 'DESC');
		$query = $queryBuilder->getQuery();

		//ligne ci-dessous identique en DQL ou QueryBuilder
		$query->setMaxResults(50); // limitation du nombre de retour à 50
		return $query->getResult();
	}
}
