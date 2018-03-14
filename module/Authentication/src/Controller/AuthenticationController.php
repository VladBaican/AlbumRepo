<?php
namespace Authentication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Permissions\Acl\Resource\ResourceInterface;
use \Application\Model\AlertMessage;
use \Application\Services\AclService;
use Authentication\Services\AuthenticationService;
use Authentication\Form\AuthenticationForm;
use Authentication\Model\AuthenticationValidator;
use Authentication\Model\User;

/**
 * Authentication Controller
 */
class AuthenticationController extends AbstractActionController
{
    /**
     * @var AuthenticationForm
     */
    protected $form;

    /**
     * @var AuthenticationService
     */
    protected $authentication;

    /**
     * @var UserTable
     */
    protected $userTable;

    /**
     * @var AclService
     */
    protected $acl;

    /**
     * Constructor.
     *
     * @param AuthenticationForm    $form
     * @param AuthenticationService $authentication
     */
    public function __construct(
        AuthenticationForm $form,
        AuthenticationService $authentication,
        AclService $acl
    ) {
        $this->form = $form;
        $this->authentication = $authentication;
        $this->acl = $acl;
    }

    /**
     * Index action.
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        if (AclService::GUEST_ROLE != $this->acl->getUserRole()) {
            return $this->redirect()->toRoute('home');
        }

        $this->layout()->setTemplate('layout/emptyLayout.phtml');
        return new ViewModel(['form' => $this->form]);
    }

    /**
     * Authenticate with the provided credentials.
     *
     * @return Response
     */
    public function loginAction()
    {
        $request = $this->getRequest();

        if (! $request->isPost()) {
            return $this->redirect()->toRoute('authentication');
        }

        $this->form->setData($request->getPost());
        $this->form->setInputFilter($this->authentication->getInputFilter());

        if (! $this->form->isValid()) {
            $alertMessage = new AlertMessage(
                AlertMessage::TYPE_WARNING,
                'Empty credentials not allowed!'
            );
            $this->flashMessenger()->addMessage($alertMessage);

            return $this->redirect()->toRoute('authentication');
        }

        $credentials = $this->form->getData();

        // Set the input credential values:
        $this->authentication
            ->getAdapter()
            ->setIdentity($credentials['username'])
            ->setCredential($credentials['password']);

        // Perform the authentication query, saving the result
        $result = $this->authentication->authenticate();

        if (AuthenticationService::LOGIN_SUCCESS != $result->getCode()) {
            $alertMessage = new AlertMessage(
                AlertMessage::TYPE_DANGER,
                'Authentication failed!'
            );
            $this->flashMessenger()->addMessage($alertMessage);

            return $this->redirect()->toRoute('authentication');
        }

        $alertMessage = new AlertMessage(
            AlertMessage::TYPE_SUCCESS,
            implode('\n', $result->getMessages())
        );
        $this->flashMessenger()->addMessage($alertMessage);

        return $this->redirect()->toRoute('home');
    }

    /**
     * Register the credentials given.
     *
     * @return Response
     */
    public function registerAction()
    {
        $request = $this->getRequest();

        if (! $request->isPost()) {
            return $this->redirect()->toRoute('home');
        }

        $this->form->setData($request->getPost());
        $this->form->setInputFilter($this->authentication->getInputFilter());

        if (! $this->form->isValid()) {
            $alertMessage = new AlertMessage(
                AlertMessage::TYPE_WARNING,
                'Empty credentials not allowed!'
            );
            $this->flashMessenger()->addMessage($alertMessage);

            return $this->redirect()->toRoute('authentication');
        }

        $credentials = $this->form->getData();
        $user = new User($credentials['username'], $credentials['password']);

        $this->authentication->saveUser($user);

        $alertMessage = new AlertMessage(
            AlertMessage::TYPE_SUCCESS,
            'Account registered!'
        );
        $this->flashMessenger()->addMessage($alertMessage);

        return $this->redirect()->toRoute('authentication');
    }

    /**
     * Logout Action.
     *
     * @return Response
     */
    public function logoutAction()
    {
        $this->authentication->clearIdentity();
        $this->redirect()->toRoute('authentication');
    }
}
