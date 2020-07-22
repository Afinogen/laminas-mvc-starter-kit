<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Db\Table\Column;
use Phinx\Migration\AbstractMigration;

final class User extends AbstractMigration
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
        $table = $this->table('user');
        $table
            ->addColumn(
                (new Column())
                ->setType(Column::STRING)
                ->setName('email')
                ->setLimit(64)
                ->setNull(false)
            )
            ->addColumn(
                (new Column())
                    ->setType(Column::STRING)
                    ->setName('password')
                    ->setLimit(255)
                    ->setNull(false)
            )
            ->addColumn(
                (new Column())
                    ->setType(Column::INTEGER)
                    ->setName('is_deleted')
                    ->setLimit(MysqlAdapter::INT_TINY)
                    ->setNull(false)
                    ->setSigned(false)
                    ->setDefault(0)
            )
            ->save();
    }
}
