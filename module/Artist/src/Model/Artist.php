<?php
namespace Artist\Model;

class Artist
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $birthday;

    /**
     * @var boolean
     */
    protected $isMarried;

    /**
     * @var int
     */
    protected $numberOfAlbums;

    /**
     * @param string $name
     * @param string $birthday
     * @param boolean $isMarried
     * @param int|null $id
     */
    public function __construct($name, $birthday, $isMarried, $numberOfAlbums = 0, $id = null)
    {
        $this->name = $name;
        $this->birthday = $birthday;
        $this->isMarried = $isMarried;
        $this->numberOfAlbums = $numberOfAlbums;
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @return boolean
     */
    public function getCivilState()
    {
        return $this->isMarried;
    }

    /**
     * @return int
     */
    public function getNumberOfAlbums()
    {
        return $this->numberOfAlbums;
    }

    public function setNumberOfAlbums($number)
    {
        $this->numberOfAlbums = $number;
    }
}
