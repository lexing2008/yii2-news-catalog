<?php

namespace common\models\db;

use Yii;

/**
 * Модель Рубрики
 *
 * @property int $id id рубрики
 * @property string $title название рубрики
 * @property int $pid id родительской рубрики
 * @property int $position позиция в рубрике
 *
 * @property NewsRubrics[] $newsRubrics
 */
class Rubrics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rubrics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['pid', 'position'], 'integer'],
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
            'pid' => 'Pid',
            'position' => 'Position',
        ];
    }

    /**
     * Gets query for [[NewsRubrics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNewsRubrics()
    {
        return $this->hasMany(NewsRubrics::className(), ['rubric_id' => 'id']);
    }
}
