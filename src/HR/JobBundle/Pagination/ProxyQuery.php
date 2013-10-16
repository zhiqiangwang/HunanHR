<?php
namespace HR\JobBundle\Pagination;
use Doctrine\ORM\QueryBuilder;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ProxyQuery
{
    protected $query;
    protected $hydrationMode;
    protected $totalResults = null;

    public function __construct(QueryBuilder $query, $hydration_mode = null)
    {
        $this->query         = $query;
        $this->hydrationMode = $hydration_mode;
    }

    /**
     * Returns the count query instance
     *
     * @return QueryBuilder
     */
    public function getCountQuery()
    {
        $a = $this->query->getRootAlias();

        $qb = clone $this->query;

        return $qb->select('COUNT(' . $a . ')')->resetDQLPart('orderBy')->setMaxResults(null)->setFirstResult(null);
    }

    /**
     * Returns the total number of results
     *
     * @return integer
     */
    public function getTotalResults()
    {
        if (null === $this->totalResults) {
            $this->totalResults = $this->getCountQuery()->getQuery()->getSingleScalarResult();
        }

        return $this->totalResults;
    }

    /**
     * Returns the list of results
     *
     * @param integer $offset
     * @param integer $limit
     *
     * @return array
     */
    public function getResults($offset, $limit)
    {
        return $this->query->setFirstResult($offset)->setMaxResults($limit)->getQuery()->execute(array(), $this->hydrationMode);
    }
}