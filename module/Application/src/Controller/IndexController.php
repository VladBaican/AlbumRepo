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
use Zend\Permissions\Acl\Resource\ResourceInterface;
use Application\Services\AclService;

/**
 * Index Controller
 */
class IndexController extends AbstractActionController
{
    /**
     * @var AclService
     */
    protected $acl;

    /**
     * @var AuthenticationService
     */
    protected $authentication;

    /**
     * Constructor.
     *
     * @param AuthenticationService $authentication
     */
    public function __construct(
        AclService $acl,
        AuthenticationService $authentication
    ) {
        $this->acl = $acl;
        $this->authentication = $authentication;
    }

    /**
     * Index Action.
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        if (AclService::GUEST_ROLE == $this->acl->getUserRole()) {
            return $this->redirect()->toRoute('authentication');
        }

        return new ViewModel();
    }
}
