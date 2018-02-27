<?php
namespace Album\AlbumEventListener;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Album\Event\AlbumCreated;
use Album\Event\AlbumDeleted;
use Album\Event\AlbumUpdated;
use Album\Model\AlbumTable;
use \Artist\Service\ArtistService;

/*
 * Album Event Listener
 */
class AlbumEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @var AlbumTable
     */
    protected $albumTable;

    /**
     * @var ArtistService
     */
    protected $artistService;

    /**
     * Constructor.
     *
     * @param AlbumTable    $albumTable
     * @param ArtistService $artistService
     */
    public function __construct(
        AlbumTable $albumTable,
        ArtistService $artistService
    ) {
        $this->albumTable = $albumTable;
        $this->artistService = $artistService;
    }

    /**
     * Register the listeners.
     *
     * @param  EventManagerInterface $events
     * @param  integer               $priority
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            AlbumCreated::NAME,
            [$this, 'onAlbumCreated']
        );
        $this->listeners[] = $events->attach(
            AlbumDeleted::NAME,
            [$this, 'onAlbumDeleted']
        );
        $this->listeners[] = $events->attach(
            AlbumUpdated::NAME,
            [$this, 'onAlbumUpdated']
        );
    }

    /**
     * Album created event handler.
     *
     * @param  AlbumCreated $event
     */
    public function onAlbumCreated(AlbumCreated $event)
    {
        $this->updateAlbumCount($event);
    }

    /**
     * Album deleted event handler.
     *
     * @param  AlbumDeleted $event
     */
    public function onAlbumDeleted(AlbumDeleted $event)
    {
        $this->updateAlbumCount($event);
    }

    /**
     * Album updated event handler.
     *
     * @param  AlbumUpdated $event
     */
    public function onAlbumUpdated(AlbumUpdated $event)
    {
        $this->updateAlbumCount($event);
    }

    /**
     * Update album count.
     *
     * @param  EventInterface  $event
     */
    protected function updateAlbumCount(EventInterface $event)
    {
        $params = $event->getParams();
        $artist = $this->albumTable->getArtist($params['album']);

        $this->artistService->updateAlbumCount($artist);
    }
}
