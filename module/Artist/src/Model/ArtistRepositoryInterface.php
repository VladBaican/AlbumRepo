<?php
namespace Artist\Model;

interface ArtistRepositoryInterface
{
    /**
     * Return a set of all artists that we can iterate over.
     *
     * Each entry should be a Artist instance.
     *
     * @return Artist[]
     */
    public function findAllArtists();

    /**
     * Return a single artist.
     *
     * @param  int $id Identifier of the artist to return.
     * @return Artist
     */
    public function findArtist($id);

    /**
     * Persist a new artist in the system.
     *
     * @param Artist $artist The artist to insert; may or may not have an identifier.
     * @return Artist The inserted artist, with identifier.
     */
    public function insertArtist(Artist $artist);

    /**
     * Delete a artist from the system.
     *
     * @param Artist $artist The artist to delete.
     * @return bool
     */
    public function deleteArtist(Artist $artist);

    /**
     * Update an existing artist in the system.
     *
     * @param Artist $artist The artist to update; must have an identifier.
     * @return Artist The updated artist.
     */
    public function updateArtist(Artist $artist);
}
