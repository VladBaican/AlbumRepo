<?php
namespace Album\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Artist\Model\Artist;
use Artist\Model\ZendDbSqlRepository;

class AlbumTable
{
    protected $tableGateway;
    protected $artistRepository;

    public function __construct(
        TableGatewayInterface $tableGateway,
        ZendDbSqlRepository $artistRepository
    ) {
        $this->tableGateway = $tableGateway;
        $this->artistRepository = $artistRepository;
    }

    public function getArtist(Album $album)
    {
        return $this->artistRepository->findArtist($album->artistId);
    }

    public function findAllArtists()
    {
        return $this->artistRepository->findAllArtists();
    }

    public function updateArtist($artist)
    {
        return $this->artistRepository->updateArtist($artist);
    }

    public function fetchAll($paginated = false)
    {
        if ($paginated) {
            return $this->fetchPaginatedResults();
        }

        return $this->tableGateway->select();
    }

    protected function fetchPaginatedResults()
    {
        // Create a new Select object for the table:
        $select = new Select($this->tableGateway->getTable());

        // Create a new result set based on the Album entity:
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Album());

        // Create a new pagination adapter object:
        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter(),
            $resultSetPrototype
        );

        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }

    public function getAlbum($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveAlbum(Album $album)
    {
        $data = [
            'artistId' => $album->artistId,
            'title'  => $album->title,
        ];
        $id = (int) $album->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getAlbum($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteAlbum($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }

    public function countAlbumsForArtist($artist)
    {
        $artistId = $artist->getId();
        $rowset = $this->tableGateway->select(['artistId' => $artistId]);
        return count($rowset);
    }
}
