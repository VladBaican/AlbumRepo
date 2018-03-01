<?php
namespace Artist\Controller;

use Artist\Form\ArtistForm;
use Artist\Model\Artist;
use Artist\Model\ArtistRepositoryInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\EventManager\EventManager;
use Zend\EventManager\SharedEventManager;
use \Application\Model\AlertMessage;

/*
 * Artist Controller
 */
class ArtistController extends AbstractActionController
{
    /**
     * @var ArtistForm
     */
    protected $form;

    /**
     * @var ArtistRepositoryInterface
     */
    protected $repository;

    protected $eventManager;

    /**
     * @param ArtistForm $form
     * @param PostCommandInterface $command
     */
    public function __construct(
        ArtistForm $form,
        ArtistRepositoryInterface $repository,
        EventManager $eventManager
    ) {

        $this->form = $form;
        $this->repository = $repository;
        $this->eventManager = $eventManager;
    }

    public function indexAction()
    {
        return new ViewModel([
            'artists' => $this->repository->findAllArtists(),
        ]);
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

        $artist = $this->form->getData();

        try {
            $artist = $this->repository->insertArtist($artist);
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
            'Artist added succesfully!'
        );
        $this->flashMessenger()->addMessage($alertMessage);

        return $this->redirect()->toRoute('artist');
    }

    /**
     * Delete action.
     *
     * @return Response
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');

        try {
            $artist = $this->repository->findArtist($id);
        } catch (InvalidArgumentException $ex) {
            $alertMessage = new AlertMessage(
                AlertMessage::TYPE_DANGER,
                'Artist not fount!'
            );
            $this->flashMessenger()->addMessage($alertMessage);

            return $this->redirect()->toRoute('artist');
        }

        $request = $this->getRequest();
        if (! $request->isPost()) {
            return new ViewModel(['artist' => $artist]);
        }

        if ($id != $request->getPost('id')
            || 'Delete' !== $request->getPost('confirm', 'no')
        ) {
            return $this->redirect()->toRoute('artist');
        }

        $alertMessage = new AlertMessage(
            AlertMessage::TYPE_SUCCESS,
            'Artist deleted succesfully!'
        );
        $this->flashMessenger()->addMessage($alertMessage);

        $artist = $this->repository->deleteArtist($artist);
        return $this->redirect()->toRoute('artist');
    }

    /**
     * Edit action
     *
     * @return Response
     */
    public function editAction()
    {
        $id = $this->params()->fromRoute('id');
        if (! $id) {
            return $this->redirect()->toRoute('artist');
        }

        try {
            $artist = $this->repository->findArtist($id);
        } catch (InvalidArgumentException $ex) {
            $alertMessage = new AlertMessage(
                AlertMessage::TYPE_DANGER,
                'Artist not fount!'
            );
            $this->flashMessenger()->addMessage($alertMessage);

            return $this->redirect()->toRoute('artist');
        }

        $this->form->bind($artist);
        $viewModel = new ViewModel(['form' => $this->form]);

        $request = $this->getRequest();
        if (! $request->isPost()) {
            return $viewModel;
        }

        $this->form->setData($request->getPost());

        if (! $this->form->isValid()) {
            return $viewModel;
        }

        $alertMessage = new AlertMessage(
            AlertMessage::TYPE_SUCCESS,
            'Artist edited succesfully!'
        );
        $this->flashMessenger()->addMessage($alertMessage);

        $artist = $this->repository->updateArtist($artist);
        return $this->redirect()->toRoute('artist');
    }
}
