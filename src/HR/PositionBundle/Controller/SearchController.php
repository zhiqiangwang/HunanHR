<?php
namespace HR\PositionBundle\Controller;

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
                    'fragment_size' => 1000,
                ),
                'companyName' => array(
                    'fragment_size' => 2000,
                )
            ),
            'pre_tags'  => array('[tag]'),
            'post_tags' => array('[/tag]'),
        ));

        $paginator = $finder->findPaginated($query);
        $paginator->setCurrentPage($request->get('page', 1));

        return $this->render('HRPositionBundle:Search:query.html.twig', array(
            'pager' => $paginator
        ));
    }
}