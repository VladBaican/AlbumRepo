<?php
namespace Artist\Form;

use Artist\Model\Artist;
use Zend\Hydrator\Reflection as ReflectionHydrator;
use Zend\Form\Fieldset;

class ArtistFieldset extends Fieldset
{
    public function init()
    {
        $this->setHydrator(new ReflectionHydrator());
        $this->setObject(new Artist('', '', false));

        $this->add([
            'type' => 'hidden',
            'name' => 'id',
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'name',
            'options' => [
                'label' => 'Artist Name',
            ],
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'birthday',
            'options' => [
                'label' => 'Artist birthday',
            ],
        ]);

        $this->add([
            'type' => 'checkbox',
            'name' => 'isMarried',
            'options' => [
                'label' => 'Married',
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0
            ],
        ]);
    }
}
