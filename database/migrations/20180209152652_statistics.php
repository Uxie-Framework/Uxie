<?php


use Phinx\Migration\AbstractMigration;

class Statistics extends AbstractMigration
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
        $hits = $this->table('statistics_hits', ['id' => false ,'primary_key' => 'id']);
        $hits
         ->addColumn('id', 'string', ['limit' => 30])
         ->addColumn('ip', 'string', ['limit' => 16])
         ->addColumn('os', 'string', ['limit' => 30])
         ->addColumn('browser', 'string', ['limit' => 30])
         ->addColumn('currenturl', 'string', ['limit' => 255])
         ->addColumn('previousurl', 'string', ['limit' => 255, 'null' => true])
         ->addColumn('date', 'datetime')
         ->addColumn('memory', 'integer')
         ->addColumn('softdelete', 'boolean')
         ->addColumn('created_at', 'datetime')
         ->addColumn('deleted_at', 'datetime')
         ->create();

        $uniq = $this->table('statistics_uniq', ['id' => false ,'primary_key' => 'id']);
        $uniq
         ->addColumn('id', 'string', ['limit' => 30])
         ->addColumn('hits', 'integer', ['limit' => 5])
         ->addColumn('softdelete', 'boolean', ['default' => 0])
         ->addColumn('created_at', 'datetime')
         ->addColumn('deleted_at', 'datetime')
         ->create();
    }
}
