<?php


use Phinx\Migration\AbstractMigration;

class Statistics extends AbstractMigration
{
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
        ->addColumn('softdelete', 'boolean', ['default' => 0])
        ->addColumn('created_at', 'datetime')
        ->addColumn('deleted_at', 'datetime', ['null' => true])
        ->create();

        $uniq = $this->table('statistics_uniq', ['id' => false ,'primary_key' => 'id']);
        $uniq
        ->addColumn('id', 'string', ['limit' => 30])
        ->addColumn('hits', 'integer', ['limit' => 5])
        ->addColumn('softdelete', 'boolean', ['default' => 0])
        ->addColumn('created_at', 'datetime')
        ->addColumn('deleted_at', 'datetime', ['null' => true])
        ->create();
    }
}
