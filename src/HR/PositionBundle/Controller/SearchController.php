<?php
namespace HR\PositionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class SearchController extends Controller
{
    public function queryAction(Request $request)
    {
        if (null == $query = $request->get('q')) {
            return $this->redirect($this->generateUrl('home'));
        }

        /** @var \FOS\ElasticaBundle\Finder\TransformedFinder $finder */
        $finder = $this->get('fos_elastica.finder.website.position');

        $paginator = $finder->findPaginated($query);
        $paginator->setCurrentPage($request->get('page', 1));

        return $this->render('HRPositionBundle:Search:query.html.twig', array(
            'pager' => $paginator
        ));
    }
}