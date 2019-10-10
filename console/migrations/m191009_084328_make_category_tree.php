<?php

use yii\db\Migration;

/**
 * Class m191009_084328_make_category_tree
 */
class m191009_084328_make_category_tree extends Migration
{
    const TABLE_NAME = 'ProductCategory';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /*
         'id' => $this->bigPrimaryKey(),
            'root' => $this->integer(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'lvl' => $this->smallInteger(5)->notNull(),
            'name' => $this->string(60)->notNull(),
            'icon' => $this->string(255),
            'icon_type' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'active' => $this->boolean()->notNull()->defaultValue(true),
            'selected' => $this->boolean()->notNull()->defaultValue(false),
            'disabled' => $this->boolean()->notNull()->defaultValue(false),
            'readonly' => $this->boolean()->notNull()->defaultValue(false),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
            'collapsed' => $this->boolean()->notNull()->defaultValue(false),
            'movable_u' => $this->boolean()->notNull()->defaultValue(true),
            'movable_d' => $this->boolean()->notNull()->defaultValue(true),
            'movable_l' => $this->boolean()->notNull()->defaultValue(true),
            'movable_r' => $this->boolean()->notNull()->defaultValue(true),
            'removable' => $this->boolean()->notNull()->defaultValue(true),
            'removable_all' => $this->boolean()->notNull()->defaultValue(false)
         */

        $table = $this->db->schema->getTableSchema(self::TABLE_NAME, true);
        if (!$table) {
            return false;
        }

        $this->addColumn(self::TABLE_NAME, 'root', $this->integer());
        $this->addColumn(self::TABLE_NAME, 'lft', $this->integer()->notNull());
        $this->addColumn(self::TABLE_NAME, 'rgt', $this->integer()->notNull());
        $this->addColumn(self::TABLE_NAME, 'lvl', $this->smallInteger(5)->notNull());
        $this->addColumn(self::TABLE_NAME, 'icon', $this->string(255));
        $this->addColumn(self::TABLE_NAME, 'icon_type', $this->smallInteger(1)->notNull()->defaultValue(1));
        $this->addColumn(self::TABLE_NAME, 'active', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'selected', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn(self::TABLE_NAME, 'disabled', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn(self::TABLE_NAME, 'readonly', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn(self::TABLE_NAME, 'visible', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'collapsed', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn(self::TABLE_NAME, 'movable_u', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'movable_d', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'movable_l', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'movable_r', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'removable', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn(self::TABLE_NAME, 'removable_all', $this->boolean()->notNull()->defaultValue(false));

        if (!isset($table->columns['child_allowed'])) {
            $this->addColumn(self::TABLE_NAME, 'child_allowed', $this->boolean()->notNull()->defaultValue(true));
        }

        return true;

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191009_084328_make_category_tree cannot be reverted.\n";

        return false;
    }
    */
}
