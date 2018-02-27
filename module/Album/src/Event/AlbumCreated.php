<?php
namespace Album\Event;

use Zend\EventManager\Event;
use Model\Album;

class AlbumCreated extends Event
{
    const NAME = 'album.created';

    protected $album;

    public function __construct($name = null, $target = null, $params = null)
    {
        parent::__construct($name, $target, $params);
        $this->setName(self::NAME);
        $this->album = $this->getParam('album');
    }
}
