<?php
namespace Artist\Service;

use \Artist\Model\Artist;
use \Artist\Model\ArtistRepositoryInterface;
use \Album\Model\AlbumTable;

/**
 * Artist Service
 */
class ArtistService
{
    /**
     * @var AlbumTable
     */
    protected $albumTable;

    /**
     * @var ArtistRepositoryInterface
     */
    protected $artistTable;

    /**
     * Constructor.
     *
     * @param AlbumTable                $albumTable
     * @param ArtistRepositoryInterface $artistTable
     */
    public function __construct(
        AlbumTable $albumTable,
        ArtistRepositoryInterface $artistTable
    ) {
        $this->albumTable = $albumTable;
        $this->artistTable = $artistTable;
    }

    /**
     * Update album count.
     *
     * @param  Artist $artist
     * @return Artist
     */
    public function updateAlbumCount(Artist $artist)
    {
        $numberOfAlbums = $this->albumTable
            ->countAlbumsForArtist($artist);

        $artist->setNumberOfAlbums($numberOfAlbums);

        return $this->artistTable->updateArtist($artist);
    }
}
