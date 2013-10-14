<?php
namespace HR\Bundle\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class HomeController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {
        /** @var \HR\Bundle\JobBundle\EntityManager\JobManager $jobManager */
        $jobManager = $this->get('job.manager.default');
        $pager      = $jobManager->findJobsPagerByLatest($request->get('page'));

        return array(
            'pager' => $pager
        );
    }
}