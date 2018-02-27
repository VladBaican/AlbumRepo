<?php
namespace Blog\Controller;

use Blog\Model\Post;
use Blog\Model\PostCommandInterface;
use Blog\Model\PostRepositoryInterface;
use InvalidArgumentException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Application\Model\AlertMessage;

class DeleteController extends AbstractActionController
{
    /**
     * @var PostCommandInterface
     */
    protected $command;

    /**
     * @var PostRepositoryInterface
     */
    protected $repository;

    /**
     * @param PostCommandInterface $command
     * @param PostRepositoryInterface $repository
     */
    public function __construct(
        PostCommandInterface $command,
        PostRepositoryInterface $repository
    ) {
        $this->command = $command;
        $this->repository = $repository;
    }

    public function deleteAction()
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

        $request = $this->getRequest();
        if (! $request->isPost()) {
            return new ViewModel(['post' => $post]);
        }

        if ($id != $request->getPost('id')
            || 'Delete' !== $request->getPost('confirm', 'no')
        ) {
            return $this->redirect()->toRoute('blog');
        }

        $alertMessage = new AlertMessage(
            AlertMessage::TYPE_SUCCESS,
            'Post deleted succesfully!'
        );
        $this->flashMessenger()->addMessage($alertMessage);

        $post = $this->command->deletePost($post);
        return $this->redirect()->toRoute('blog');
    }
}
