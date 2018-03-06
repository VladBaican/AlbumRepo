<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Services\TranslatorService;
use \Authentication\Services\AuthenticationService;

/**
 * Index Controller
 */
class IndexController extends AbstractActionController
{
    protected $authentication;

    /**
     * Constructor.
     *
     * @param AuthenticationService $authentication
     */
    public function __construct(AuthenticationService $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * Index Action.
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $identity = $this->authentication->hasIdentity();

        if (! $identity) {
            return $this->redirect()->toRoute('authentication');
        }

        return new ViewModel();
    }
}
