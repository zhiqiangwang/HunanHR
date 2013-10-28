<?php
namespace HR\PositionBundle\Controller;

use Elastica\Filter\BoolNot;
use Elastica\Filter\Ids;
use Elastica\Query\MoreLikeThis;
use Elastica\Query\QueryString;
use Elastica\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class SearchController extends Controller
{
    public function queryAction(Request $request)
    {
        if (null == $queryString = $request->get('q')) {
            return $this->redirect($this->generateUrl('home'));
        }

        if (false !== mb_stripos($queryString, '*')) {
            return $this->redirect($this->generateUrl('home'));
        }

        $this->get('breadcrumb')->add(sprintf('%s 职位搜索结果', $queryString));

        /** @var \FOS\ElasticaBundle\Finder\TransformedFinder $finder */
        $finder = $this->get('fos_elastica.finder.website.position');

        $queryString = new QueryString($queryString);
        $queryString->setDefaultOperator('AND');

        $query = new Query($queryString);
        $query->setHighlight(array(
            'fields'    => array(
                'description' => array(
                    'fragment_size' => 2000,
                ),
                'position'    => array(
                    'fragment_size' => 500,
                ),
                'companyName' => array(
                    'fragment_size' => 100,
                ),
                'location'    => array(
                    'fragment_size' => 500,
                )
            ),
            'pre_tags'  => array('[tag]'),
            'post_tags' => array('[/tag]'),
        ));

        /** @var \Knp\Component\Pager\Paginator $paginator */
        $paginator = $this->get('paginator');
        $pager     = $paginator->paginate($finder->createPaginatorAdapter($query), $request->get('page', 1));

        return $this->render('HRPositionBundle:Search:query.html.twig', array(
            'pager' => $pager
        ));
    }

    public function similarAction(Request $request)
    {
        $positionId = $request->get('positionId');

        /** @var \HR\PositionBundle\Entity\Position $position */
        $position = $this->get('position.manager.default')->findPositionById($positionId);

        if (!$position) {
            throw $this->createNotFoundException();
        }

        /** @var \FOS\ElasticaBundle\Finder\TransformedFinder $finder */
        $finder = $this->get('fos_elastica.finder.website.position');

        $mltQuery = new MoreLikeThis();
        $mltQuery->setLikeText($position->getPosition());
        $mltQuery->setFields(array('position'));
        $mltQuery->setMaxQueryTerms(5);
        $mltQuery->setMinDocFrequency(1.5);
        $mltQuery->setMinTermFrequency(1.5);

        $idsFilter = new Ids();
        $idsFilter->addId($positionId);

        $query = new Query($mltQuery);
        $query->setFilter(new BoolNot($idsFilter));
        $query->setFrom(0);
        $query->setSize(5);
        $positions = $finder->find($query);

        return $this->stream('HRPositionBundle:Search:similar.html.twig', array(
            'positions' => $positions
        ));
    }
}