<?php

use yii\db\Migration;

/**
 * Class m201002_141430_create_rubrics
 */
class m201002_141430_create_rubrics extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица rubrics
        // Содержит информацию о рубриках
        $this->createTable('rubrics', [
            'id'            => $this->primaryKey()->unsigned()->comment('id рубрики'),
            'title'         => $this->string()->notNull()->comment('название рубрики'),
            'pid'           => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('id родительской рубрики'),
            'position'      => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('позиция в рубрике'),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        
        $this->addCommentOnTable('rubrics', 'Содержит список рубрик');
        
        $this->insert('rubrics', ['id' => 1, 'title' => 'Общество', 'pid' => 0, 'position' => 0]);
        $this->insert('rubrics', ['id' => 2, 'title' => 'День города', 'pid' => 0, 'position' => 1]);
        $this->insert('rubrics', ['id' => 3, 'title' => '0-3 года', 'pid' => 0, 'position' => 2]);
        $this->insert('rubrics', ['id' => 4, 'title' => '3-7 года', 'pid' => 0, 'position' => 3]);
        $this->insert('rubrics', ['id' => 5, 'title' => 'Спорт', 'pid' => 0, 'position' => 4]);
        $this->insert('rubrics', ['id' => 6, 'title' => 'городская жизнь', 'pid' => 1, 'position' => 0]);
        $this->insert('rubrics', ['id' => 7, 'title' => 'выборы', 'pid' => 1, 'position' => 1]);
        $this->insert('rubrics', ['id' => 8, 'title' => 'салюты', 'pid' => 2, 'position' => 0]);
        $this->insert('rubrics', ['id' => 9, 'title' => 'детская площадка', 'pid' => 2, 'position' => 1]);
        $this->insert('rubrics', ['id' => 10, 'title' => 'летом', 'pid' => 6, 'position' => 0]);
        $this->insert('rubrics', ['id' => 11, 'title' => 'зимой', 'pid' => 6, 'position' => 1]);
        $this->insert('rubrics', ['id' => 12, 'title' => 'в июле', 'pid' => 10, 'position' => 0]);
        $this->insert('rubrics', ['id' => 13, 'title' => 'в августе', 'pid' => 10, 'position' => 1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201002_141430_create_rubrics cannot be reverted.\n";

        $this->dropTable('rubrics');
    }
}
