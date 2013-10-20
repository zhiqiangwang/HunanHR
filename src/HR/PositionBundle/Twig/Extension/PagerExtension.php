<?php
namespace HR\PositionBundle\Twig\Extension;
use HR\PositionBundle\Pagination\Pager;
use Symfony\Component\DependencyInjection\Container;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class PagerExtension extends \Twig_Extension
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            'paginate'      => new \Twig_Function_Method($this, 'paginate', array('is_safe' => array('html'))),
            'paginate_path' => new \Twig_Function_Method($this, 'paginate_path', array('is_safe' => array('html'))),
        );
    }

    /**
     * @param Pager  $pager
     * @param string $route
     * @param array  $parameters
     *
     * @return string
     */
    public function paginate(Pager $pager, $route, array $parameters = array())
    {
        return $this->container->get('templating')->render('HRPositionBundle:Pager:pagination.html.twig', array(
            'pager'      => $pager,
            'route'      => $route,
            'parameters' => $parameters
        ));
    }

    /**
     * @param string  $route
     * @param integer $page
     * @param array   $parameters
     *
     * @return string
     */
    public function paginate_path($route, $page, array $parameters = array())
    {
        if (isset($parameters['_page'])) {
            $parameters[$parameters['_page']] = $page;

            unset($parameters['_page']);
        } else {
            $parameters['page'] = $page;
        }

        return $this->container->get('router')->generate($route, $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'markup_extension.pager';
    }
}