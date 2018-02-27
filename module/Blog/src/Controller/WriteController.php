<?php
namespace Blog\Controller;

use Blog\Form\PostForm;
use Blog\Model\Post;
use Blog\Model\PostCommandInterface;
use Blog\Model\PostRepositoryInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Application\Model\AlertMessage;

class WriteController extends AbstractActionController
{
    /**
     * @var PostCommandInterface
     */
    protected $command;

    /**
     * @var PostForm
     */
    protected $form;

    /**
     * @var PostRepositoryInterface
     */
    protected $repository;

    /**
     * @param PostCommandInterface $command
     * @param PostForm $form
     */
    public function __construct(
        PostCommandInterface $command,
        PostForm $form,
        PostRepositoryInterface $repository
    ) {
        $this->command = $command;
        $this->form = $form;
        $this->repository = $repository;
    }

    /**
     * Add action.
     *
     * @return Response
     */
    public function addAction()
    {
        $request   = $this->getRequest();
        $viewModel = new ViewModel(['form' => $this->form]);

        if (! $request->isPost()) {
            return $viewModel;
        }

        $this->form->setData($request->getPost());

        if (! $this->form->isValid()) {
            return $viewModel;
        }

        $post = $this->form->getData();

        try {
            $post = $this->command->insertPost($post);
        } catch (\Exception $ex) {
            // An exception occurred; we may want to log this later and/or
            // report it to the user. For now, we'll just re-throw.
            $alertMessage = new AlertMessage(
                AlertMessage::TYPE_WARNING,
                'Something went wrong!'
            );
            $this->flashMessenger()->addMessage($alertMessage);

            throw $ex;
        }

        $alertMessage = new AlertMessage(
            AlertMessage::TYPE_SUCCESS,
            'Post added succesfully!'
        );
        $this->flashMessenger()->addMessage($alertMessage);

        return $this->redirect()->toRoute(
            'blog/detail',
            ['id' => $post->getId()]
        );
    }

    /**
     * Edit action.
     *
     * @return Response
     */
    public function editAction()
    {
        $id = $this->params()->fromRoute('id');
        if (! $id) {
            return $this->redirect()->toRoute('blog');
        }

        try {
            $post = $this->repository->findPost($id);
        } catch (InvalidArgumentException $ex) {
            $alertMessage = new AlertMessage(
                AlertMessage::TYPE_DANGER,
                'Post not found!'
            );
            $this->flashMessenger()->addMessage($alertMessage);

            return $this->redirect()->toRoute('blog');
        }

        $this->form->bind($post);
        $viewModel = new ViewModel(['form' => $this->form]);

        $request = $this->getRequest();
        if (! $request->isPost()) {
            return $viewModel;
        }

        $this->form->setData($request->getPost());

        if (! $this->form->isValid()) {
            return $viewModel;
        }

        $post = $this->command->updatePost($post);

        $alertMessage = new AlertMessage(
            AlertMessage::TYPE_SUCCESS,
            'Post edited succesfully!'
        );
        $this->flashMessenger()->addMessage($alertMessage);

        return $this->redirect()->toRoute(
            'blog/detail',
            ['id' => $post->getId()]
        );
    }
}
