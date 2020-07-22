<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Db\Table\Column;
use Phinx\Migration\AbstractMigration;

final class UserHasRole extends AbstractMigration
{
    /**
     * Change Method.
     * Write your reversible migrations using this method.
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up(): void
    {
        $table = $this->table(
            'user_has_role', [
                'id' => false,
            ]
        );
        $table
            ->addColumn(
                (new Column())
                    ->setName('user_id')
                    ->setType(Column::INTEGER)
                    ->setLimit(MysqlAdapter::INT_REGULAR)
                    ->setNull(false)
            )
            ->addColumn(
                (new Column())
                    ->setName('role_id')
                    ->setType(Column::INTEGER)
                    ->setLimit(MysqlAdapter::INT_SMALL)
                    ->setNull(false)
            )
            ->addForeignKey(
                'user_id',
                'user',
                'id',
                [
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'role_id',
                'role',
                'id',
                [
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                    'role_id',
                ],
                ['unique' => true]
            )
            ->save();
    }

    public function down(): void
    {
        $table = $this->table('user_has_role');
        $table->dropForeignKey('user_id');
        $table->dropForeignKey('role_id');
        $table->drop();
        $table->save();

    }
}
