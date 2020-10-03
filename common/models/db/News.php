<?php

namespace common\models\db;

use Yii;

/**
 * Модель Новости
 *
 * @property int $id id новости
 * @property string $title название новости
 * @property string $text Текст новости
 *
 * @property NewsRubrics[] $newsRubrics
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
        ];
    }

    /**
     * Gets query for [[NewsRubrics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNewsRubrics()
    {
        return $this->hasMany(NewsRubrics::className(), ['news_id' => 'id']);
    }
}
