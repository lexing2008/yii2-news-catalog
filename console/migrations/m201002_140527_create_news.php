<?php

use yii\db\Migration;

/**
 * Class m201002_140527_create_news
 */
class m201002_140527_create_news extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица news
        // Содержит информацию о новостях
        $this->createTable('news', [
            'id'            => $this->primaryKey()->unsigned()->notNull()->comment('id новости'),
            'title'         => $this->string()->notNull()->comment('название новости'),
            'text'          => $this->text()->notNull()->comment('Текст новости'),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        
        $this->addCommentOnTable('news', 'Содержит список новостей');
        
        $this->insert('news', ['id' => 1, 'title' => 'Новость 1', 'text' => 'Текст 1']);
        $this->insert('news', ['id' => 2, 'title' => 'Новость 2', 'text' => 'Текст 2']);
        $this->insert('news', ['id' => 3, 'title' => 'Новость 3', 'text' => 'Текст 3']);
        $this->insert('news', ['id' => 4, 'title' => 'Новость 4', 'text' => 'Текст 4']);
        $this->insert('news', ['id' => 5, 'title' => 'Новость 5', 'text' => 'Текст 5']);
        $this->insert('news', ['id' => 6, 'title' => 'Новость 6', 'text' => 'Текст 6']);
        $this->insert('news', ['id' => 7, 'title' => 'Новость 7', 'text' => 'Текст 7']);
        $this->insert('news', ['id' => 8, 'title' => 'Новость 8', 'text' => 'Текст 8']);
        $this->insert('news', ['id' => 9, 'title' => 'Новость 9', 'text' => 'Текст 9']);
        $this->insert('news', ['id' => 10, 'title' => 'Новость 10', 'text' => 'Текст 10']);
        $this->insert('news', ['id' => 11, 'title' => 'Новость 11', 'text' => 'Текст 11']);
        $this->insert('news', ['id' => 12, 'title' => 'Новость 12', 'text' => 'Текст 12']);
        $this->insert('news', ['id' => 13, 'title' => 'Новость 13', 'text' => 'Текст 13']);
        $this->insert('news', ['id' => 14, 'title' => 'Новость 14', 'text' => 'Текст 14']);
        $this->insert('news', ['id' => 15, 'title' => 'Новость 15', 'text' => 'Текст 15']);
        $this->insert('news', ['id' => 16, 'title' => 'Новость 16', 'text' => 'Текст 16']);
        $this->insert('news', ['id' => 17, 'title' => 'Новость 17', 'text' => 'Текст 17']);
        $this->insert('news', ['id' => 18, 'title' => 'Новость 18', 'text' => 'Текст 18']);
        $this->insert('news', ['id' => 19, 'title' => 'Новость 19', 'text' => 'Текст 19']);
        $this->insert('news', ['id' => 20, 'title' => 'Новость 20', 'text' => 'Текст 20']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201002_140527_create_news cannot be reverted.\n";

        $this->dropTable('news');
    }
}
