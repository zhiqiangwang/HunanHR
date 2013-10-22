<?php

/*
 * This file is part of the Pagerfanta package.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HR\PositionBundle\Pagerfanta\View;

use Pagerfanta\PagerfantaInterface;
use Pagerfanta\View\TwitterBootstrap3View;
use Pagerfanta\View\ViewInterface;
use WhiteOctober\PagerfantaBundle\View\DefaultTranslatedView;

/**
 * TwitterBootstrap3TranslatedView
 *
 * This view renders the twitter bootstrap3 view with the text translated
 *
 */
class TwitterBootstrap3TranslatedView extends DefaultTranslatedView implements ViewInterface
{

    protected $view;

    /**
     * Constructor.
     *
     * @param TwitterBootstrap3View $view       A Twitter bootstrap3 view
     */
    public function __construct(TwitterBootstrap3View $view)
    {
        $this->view = $view;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twitter_bootstrap3_translated';
    }

    /**
     * {@inheritdoc}
     */
    public function render(PagerfantaInterface $pagerfanta, $routeGenerator, array $options = array())
    {
        if (!isset($options['prev_message'])) {
            $options['prev_message'] = '上一页';
        }
        if (!isset($options['next_message'])) {
            $options['next_message'] = '下一页';
        }

        return $this->view->render($pagerfanta, $routeGenerator, $options);
    }

}
