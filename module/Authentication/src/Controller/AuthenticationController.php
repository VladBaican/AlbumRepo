<?php
namespace Authentication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Authentication\Model\AuthenticationAdapter;

/**
 * Authentication Controller
 */
class AuthenticationController extends AbstractActionController
{
    /**
     * @var AuthenticationAdapter
     */
    protected $authentication;

    /**
     * Constructor
     */
    public function __construct(AuthenticationAdapter $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * Index action.
     *
     * @return Response
     */
    public function indexAction()
    {
        $this->layout()->setTemplate('layout/emptyLayout.phtml');
        return new ViewModel();
    }
}
