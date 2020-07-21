<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Role extends AbstractMigration
{
    /**
     * Change Method.
     * Write your reversible migrations using this method.
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('role');
        $table
            ->addColumn(
                (new \Phinx\Db\Table\Column())
                    ->setType('string')
                    ->setName('name')
                    ->setLimit(16)
                    ->setNull(false)
            )
            ->addColumn(
                (new \Phinx\Db\Table\Column())
                    ->setType('integer')
                    ->setName('parent_id')
                    ->setLimit(\Phinx\Db\Adapter\MysqlAdapter::INT_REGULAR)
                    ->setNull(true)
            )
            ->addForeignKey(
                'parent_id',
                'role',
                'id',
                [
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ]
            )
            ->save();
        if ($this->isMigratingUp()) {
            $table->insert(
                [
                    'id'        => 1,
                    'name'      => 'guest',
                    'parent_id' => null,
                ]
            );
            $table->insert(
                [
                    'id'        => 2,
                    'name'      => 'user',
                    'parent_id' => 1,
                ]
            );
            $table->saveData();
        }
    }
}
