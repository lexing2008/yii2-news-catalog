<?php

use yii\db\Migration;

/**
 * Class m201002_144121_create_news_rubrics
 */
class m201002_144121_create_news_rubrics extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица news_rubrics
        // Содержит информацию о рубриках новостей
        $this->createTable('news_rubrics', [
            'id'            => $this->primaryKey()->unsigned()->notNull()->comment('id записи'),
            'news_id'       => $this->integer()->unsigned()->notNull()->comment('id новости'),
            'rubric_id'     => $this->integer()->unsigned()->notNull()->comment('id рубрики'),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        
        $this->addCommentOnTable('news_rubrics', 'Содержит связи новостей и рубрик');

        // внешние ключи
        $this->addForeignKey('fk-news', 'news_rubrics', 'news_id', 'news', 'id', 'CASCADE');
        $this->addForeignKey('fk-rubric', 'news_rubrics', 'rubric_id', 'rubrics', 'id', 'CASCADE');
                
        $this->createIndex(
            'idx-news_id',
            'news_rubrics',
            'news_id'
        );
        
        $this->createIndex(
            'idx-rubric_id',
            'news_rubrics',
            'rubric_id'
        );
        
        $this->insert('news_rubrics', ['news_id' => 1, 'rubric_id' => 1]);
        $this->insert('news_rubrics', ['news_id' => 1, 'rubric_id' => 10]);
        $this->insert('news_rubrics', ['news_id' => 2, 'rubric_id' => 10]);
        $this->insert('news_rubrics', ['news_id' => 2, 'rubric_id' => 3]);
        $this->insert('news_rubrics', ['news_id' => 2, 'rubric_id' => 12]);
        $this->insert('news_rubrics', ['news_id' => 3, 'rubric_id' => 7]);
        $this->insert('news_rubrics', ['news_id' => 3, 'rubric_id' => 8]);
        $this->insert('news_rubrics', ['news_id' => 3, 'rubric_id' => 9]);
        $this->insert('news_rubrics', ['news_id' => 3, 'rubric_id' => 10]);
        $this->insert('news_rubrics', ['news_id' => 3, 'rubric_id' => 11]);
        $this->insert('news_rubrics', ['news_id' => 4, 'rubric_id' => 3]);
        $this->insert('news_rubrics', ['news_id' => 4, 'rubric_id' => 2]);
        $this->insert('news_rubrics', ['news_id' => 5, 'rubric_id' => 2]);
        $this->insert('news_rubrics', ['news_id' => 5, 'rubric_id' => 6]);
        $this->insert('news_rubrics', ['news_id' => 6, 'rubric_id' => 6]);
        $this->insert('news_rubrics', ['news_id' => 6, 'rubric_id' => 12]);
        $this->insert('news_rubrics', ['news_id' => 7, 'rubric_id' => 12]);
        $this->insert('news_rubrics', ['news_id' => 7, 'rubric_id' => 13]);
        $this->insert('news_rubrics', ['news_id' => 7, 'rubric_id' => 4]);
        $this->insert('news_rubrics', ['news_id' => 7, 'rubric_id' => 3]);
        $this->insert('news_rubrics', ['news_id' => 7, 'rubric_id' => 2]);
        $this->insert('news_rubrics', ['news_id' => 8, 'rubric_id' => 2]);
        $this->insert('news_rubrics', ['news_id' => 8, 'rubric_id' => 1]);
        $this->insert('news_rubrics', ['news_id' => 8, 'rubric_id' => 5]);
        $this->insert('news_rubrics', ['news_id' => 8, 'rubric_id' => 6]);
        $this->insert('news_rubrics', ['news_id' => 8, 'rubric_id' => 7]);
        $this->insert('news_rubrics', ['news_id' => 8, 'rubric_id' => 8]);
        $this->insert('news_rubrics', ['news_id' => 8, 'rubric_id' => 9]);
        $this->insert('news_rubrics', ['news_id' => 9, 'rubric_id' => 9]);
        $this->insert('news_rubrics', ['news_id' => 9, 'rubric_id' => 6]);
        $this->insert('news_rubrics', ['news_id' => 9, 'rubric_id' => 7]);
        $this->insert('news_rubrics', ['news_id' => 9, 'rubric_id' => 8]);
        $this->insert('news_rubrics', ['news_id' => 10, 'rubric_id' => 5]);
        $this->insert('news_rubrics', ['news_id' => 10, 'rubric_id' => 6]);
        $this->insert('news_rubrics', ['news_id' => 10, 'rubric_id' => 7]);
        $this->insert('news_rubrics', ['news_id' => 10, 'rubric_id' => 8]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201002_144121_create_news_rubrics cannot be reverted.\n";

        $this->dropTable('news_rubrics');
    }
}
