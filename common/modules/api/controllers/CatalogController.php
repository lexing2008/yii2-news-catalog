<?php

namespace common\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use common\helpers\RubricsHelper;
use common\models\db\NewsRubrics;

/**
 * Controller for the `Api` module
 * Контреллер Api для получения данных новостного каталога
 */
class CatalogController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['verbs'] = [
                'class'     => \yii\filters\VerbFilter::class,
                'actions'   => [
                    'get-news'    => ['GET'],
                    'get-rubrics'           => ['GET'],
                ],
            ];
        
        return $behaviors;
    }
    
    /**
     * Включение рекламных кампаний по городам
     * @return string
     */
    public function actionGetRubrics(): array
    {
        $rubricId = Yii::$app->request->get('rubric_id');
        
        if(empty($rubricId)){
            $rubricId = 0;
        }
        
        $helper = new RubricsHelper;      
        $childrens = $helper->getChildrens($rubricId);
        
        return self::getResponseOk($childrens);
    }

    /**
     * Включение рекламных кампаний по городам
     * @return string
     */
    public function actionGetNews(): array
    {
        $rubricId = Yii::$app->request->get('rubric_id');
        
        if(empty($rubricId)){
            $rubricId = 0;
        }
        
        $childrens      = (new RubricsHelper)->getChildrens($rubricId);
        
        $rubricsIds     = array_column($childrens, 'id');
        $rubricsIds[]   = $rubricId;

        $newsRubrics = NewsRubrics::find()
                            ->select('news.*, news_rubrics.rubric_id')
                            ->innerJoin('news', 'news_rubrics.news_id = news.id')
                            ->andWhere(['news_rubrics.rubric_id' => $rubricsIds])
                            ->asArray()
                            ->all();

        return self::getResponseOk($newsRubrics);
    }
    
    /**
     * Возвращает ответ сервера OK
     * @param array $data данные
     * @return array ответ OK
     */
    public static function getResponseOk(array $data): array
    {
        return [    
                    'status'    => 200,
                    'name'      => 'ok',
                    'message'   => 'Operation completed successfully.',
                    'data'      => $data
                ];
    }
}
