<?php
namespace Authentication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Application\Model\AlertMessage;
use Authentication\Services\AuthenticationService;
use Authentication\Form\AuthenticationForm;

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
     * Constructor.
     *
     * @param AuthenticationForm    $form
     * @param AuthenticationService $authentication
     */
    public function __construct(
        AuthenticationForm $form,
        AuthenticationService $authentication
    ) {
        $this->form = $form;
        $this->authentication = $authentication;
    }

    /**
     * Index action.
     *
     * @return ViewModel
     */
    public function indexAction()
    {
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

        if (! $this->form->isValid()) {
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

        if ($this->authentication::LOGIN_FAIL == $result->getCode()) {
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

        return $this->redirect()->toRoute('album');
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

        if (! $this->form->isValid()) {
            return $this->redirect()->toRoute('home');
        }

        $credentials = $this->form->getData();

        // Set the input credential values:
        $this->authentication
            ->setIdentity($credentials['username'])
            ->setCredential($credentials['password']);

        // Perform the authentication query, saving the result
        $result = $this->authentication->authenticate();

        return $this->redirect()->toRoute('album');
    }
}
