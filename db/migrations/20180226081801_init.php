<?php

use Phinx\Migration\AbstractMigration;

class Init extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $artists = $this->table('artists');
        $artists->addColumn('name', 'string', ['length' => 100])
            ->addColumn('birthday', 'date')
            ->addColumn('isMarried', 'boolean')
            ->addColumn('numberOfAlbums', 'integer')
            ->create();

        $album = $this->table('album');
        $album->addColumn('artistId', 'integer')
            ->addColumn('title', 'string', ['length' => 100])
            ->addForeignKey(
                'artistId',
                'artists',
                ['id'],
                ['constraint' => 'artist_foreign_key']
            )
            ->create();

        $posts = $this->table('posts');
        $posts->addColumn('title', 'string', ['length' => 100])
            ->addColumn('text', 'string', ['length' => 500])
            ->create();

        $users = $this->table('users');
        $users->addColumn('username', 'string', ['length' => 50])
            ->addColumn('password', 'string', ['length' => 32])
            ->create();
    }
}
