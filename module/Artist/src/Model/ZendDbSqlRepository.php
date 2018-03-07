<?php
namespace Artist\Model;

use InvalidArgumentException;
use RuntimeException;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Update;

class ZendDbSqlRepository implements ArtistRepositoryInterface
{
    /**
     * @var AdapterInterface
     */
    protected $db;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var Artist
     */
    protected $artistPrototype;

    public function __construct(
        AdapterInterface $db,
        HydratorInterface $hydrator,
        Artist $artistPrototype
    ) {
        $this->db            = $db;
        $this->hydrator      = $hydrator;
        $this->artistPrototype = $artistPrototype;
    }

    /**
     * Return a set of all artists that we can iterate over.
     *
     * Each entry should be a Artist instance.
     *
     * @return Artist[]
     */
    public function findAllArtists()
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select('artists');
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            return [];
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->artistPrototype);
        $resultSet->initialize($result);
        return $resultSet;
    }


    /**
     * Return a single artist.
     *
     * @param  int $id Identifier of the post to return.
     * @return Artist
     */
    public function findArtist($id)
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select('artists');
        $select->where(['id = ?' => $id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving artist with identifier "%s"; unknown database error.',
                $id
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->artistPrototype);
        $resultSet->initialize($result);
        $artist = $resultSet->current();

        if (! $artist) {
            throw new InvalidArgumentException(sprintf(
                'Artist with identifier "%s" not found.',
                $id
            ));
        }

        return $artist;
    }

    public function insertArtist(Artist $artist)
    {
        $insert = new Insert('artists');

        $insert->values([
            'name' => $artist->getName(),
            'birthday' => $artist->getBirthday(),
            'isMarried' => $artist->getCivilState(),
            'numberOfAlbums' => $artist->getNumberOfAlbums()
        ]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        if (! $result instanceof ResultInterface) {
            throw new RuntimeException(
                'Database error occurred during blog post insert operation'
            );
        }

        $id = $result->getGeneratedValue();

        return new Artist(
            $artist->getName(),
            $artist->getBirthday(),
            $artist->getCivilState(),
            $artist->getNumberOfAlbums(),
            $result->getGeneratedValue()
        );
    }

    public function deleteArtist(Artist $artist)
    {
        if (! $artist->getId()) {
            throw new RuntimeException('Cannot update artist; missing identifier');
        }

        $delete = new Delete('artists');
        $delete->where(['id = ?' => $artist->getId()]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();

        if (! $result instanceof ResultInterface) {
            return false;
        }

        return true;
    }

    public function updateArtist(Artist $artist)
    {
        if (! $artist->getId()) {
            throw new RuntimeException('Cannot update artist; missing identifier');
        }

        $update = new Update('artists');
        $update->set([
            'name' => $artist->getName(),
            'birthday' => $artist->getBirthday(),
            'isMarried' => $artist->getCivilState(),
            'numberOfAlbums' => $artist->getNumberOfAlbums()
        ]);
        $update->where(['id = ?' => $artist->getId()]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();

        if (! $result instanceof ResultInterface) {
            throw new RuntimeException(
                'Database error occurred during artist update operation'
            );
        }

        return $artist;
    }
}
