<?php

namespace Album\Form;

use Zend\Form\Form;
use Album\Model\AlbumTable;
use Album\Model\ZendDbSqlRepository;

class AlbumForm extends Form
{
    protected $table;

    public function __construct(AlbumTable $table = null, $name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('album');
        $this->table = $table;

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'title',
            'type' => 'text',
            'options' => [
                'label' => 'Title',
            ],
        ]);
        $this->add([
            'type' => 'Zend\Form\Element\Select',
            'name' => 'artistId',
            'options' => [
                'label' => 'Select an artist',
                'value_options' => $this->getArtistOptions()
            ]
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }

    public function getArtistOptions()
    {
        $artistList = [];

        foreach ($this->table->findAllArtists() as $artist) {
            $artistList[$artist->getId()] = $artist->getName();
        }

        return $artistList;
    }
}
