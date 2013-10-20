<?php
namespace HR\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class HomeController extends Controller
{
    public function indexAction(Request $request)
    {
        /** @var \HR\PositionBundle\EntityManager\PositionManager $positionManager */
        $positionManager = $this->get('position.manager.default');
        $pager           = $positionManager->findPositionsPagerByLatest($request->get('page', 1));

        return $this->render('HRPageBundle:Home:index.html.twig', array(
            'pager' => $pager
        ));
    }
}