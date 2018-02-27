<?php
namespace Album\Controller;

use Album\Form\AlbumForm;
use Album\Model\Album;
use Album\Model\AlbumTable;
use Album\Model\ZendDbSqlRepository;
use Album\AlbumEventListener\AlbumEventListener;
use Album\Event\AlbumCreated;
use Album\Event\AlbumDeleted;
use Album\Event\AlbumUpdated;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\EventManager\EventManager;
use \Application\Model\AlertMessage;

class AlbumController extends AbstractActionController
{
    /**
     * @var AlbumTable
     */
    protected $table;

    /**
     * @var EventManager
     */
    protected $eventManager;

    public function __construct(
        AlbumTable $table,
        EventManager $eventManager
    ) {
        $this->table = $table;
        $this->eventManager = $eventManager;
    }

    /**
     * Index action.
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $paginator = $this->table->fetchAll(true);

        // Set the current page to what has been passed in query string,
        // or to 1 if none is set, or the page is invalid:
        $page = (int) $this->params()->fromQuery('page', 1);
        $page = ($page < 1) ? 1 : $page;

        $paginator->setCurrentPageNumber($page);
        // Set the number of items per page to 10:
        $paginator->setItemCountPerPage(10);

        return new ViewModel([
            'paginator' => $paginator,
            'table' => $this->table
        ]);
    }

    /**
     * Add action.
     *
     * @return Response
     */
    public function addAction()
    {
        $form = new AlbumForm($this->table);
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();

        if (! $request->isPost()) {
            $alertMessage = new AlertMessage(
                AlertMessage::TYPE_WARNING,
                'Something went wrong!'
            );
            $this->flashMessenger()->addMessage($alertMessage);

            return ['form' => $form];
        }

        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $album->exchangeArray($form->getData());
        $this->table->saveAlbum($album);

        $this->eventManager->triggerEvent(
            new AlbumCreated(null, $this, ['album' => $album])
        );

        $alertMessage = new AlertMessage(
            AlertMessage::TYPE_SUCCESS,
            'Album added succesfully!'
        );
        $this->flashMessenger()->addMessage($alertMessage);

        return $this->redirect()->toRoute('album');
    }

    /**
     * Edit action.
     *
     * @return Response
     */
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        try {
            $album = $this->table->getAlbum($id);
        } catch (\Exception $e) {
            $alertMessage = new AlertMessage(
                AlertMessage::TYPE_DANGER,
                'Album not found!'
            );
            $this->flashMessenger()->addMessage($alertMessage);

            return self::redirect()->toRoute('album', [
                'action' => 'index',
                'status' => 'fail'
            ]);
        }

        $albumCopy = new Album();
        $albumCopy->exchangeArray($album->getArrayCopy());

        $form = new AlbumForm($this->table);
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveAlbum($album);
        $this->eventManager->triggerEvent(
            new AlbumUpdated(
                null,
                $this,
                ['album' => $album]
            )
        );
        $this->eventManager->triggerEvent(
            new AlbumUpdated(null, $this, ['album' => $albumCopy])
        );

        $alertMessage = new AlertMessage(
            AlertMessage::TYPE_SUCCESS,
            'Album edited succesfully!'
        );
        $this->flashMessenger()->addMessage($alertMessage);

        return $this->redirect()
            ->toRoute('album', ['action' => 'index', 'status' => 'succes']);
    }

    /**
     * Delete action.
     *
     * @return Response
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        try {
            $this->table->getAlbum($id);
        } catch (\Exception $e) {
            $alertMessage = new AlertMessage(
                AlertMessage::TYPE_DANGER,
                'Album not found!'
            );
            $this->flashMessenger()->addMessage($alertMessage);

            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $album = $this->table->getAlbum($id);
                $this->table->deleteAlbum($id);

                $alertMessage = new AlertMessage(
                    AlertMessage::TYPE_SUCCESS,
                    'Album deleted!'
                );
                $this->flashMessenger()->addMessage($alertMessage);

                $this->eventManager->triggerEvent(
                    new AlbumDeleted(null, $this, ['album' => $album])
                );
            }

            return $this->redirect()->toRoute('album');
        }

        return [
            'id'    => $id,
            'album' => $this->table->getAlbum($id),
        ];
    }
}
