<?php
namespace common\helpers;

use common\models\db\NewsRubrics;

/**
 * Хэлпер NewsRubricsHelper
 * позволяет работать с иерархическим списком рубрик новостей
 */
class NewsRubricsHelper 
{
    /**
     * Возвращает новости по ID рубрики
     * @param int $rubricId id рубрики
     * @return array массив новостей
     */
    public static function getNewsByRubricId(int $rubricId): array
    {
        $childrens      = (new RubricsHelper)->getChildrens($rubricId);
        
        $rubricsIds     = array_column($childrens, 'id');
        $rubricsIds[]   = $rubricId;

        $newsRubrics    = NewsRubrics::find()
                            ->select('news.*, news_rubrics.rubric_id')
                            ->innerJoin('news', 'news_rubrics.news_id = news.id')
                            ->andWhere(['news_rubrics.rubric_id' => $rubricsIds])
                            ->asArray()
                            ->all();
        
        return $newsRubrics;
    }
}