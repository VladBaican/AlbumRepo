<?php
namespace Artist\Form;

use Zend\Form\Form;

/*
 * Artist Form
 */
class ArtistForm extends Form
{
    /*
     * Initialization.
     */
    public function init()
    {
        $this->add([
            'name' => 'post',
            'type' => ArtistFieldset::class,
            'options' => [
                'use_as_base_fieldset' => true,
            ],
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Insert new Artist',
            ],
        ]);
    }
}
