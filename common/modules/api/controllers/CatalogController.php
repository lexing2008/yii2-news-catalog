<?php

namespace common\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use common\helpers\RubricsHelper;
use common\helpers\NewsRubricsHelper;

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
                    'get-rubrics' => ['GET'],
                ],
            ];
        
        return $behaviors;
    }

    /**
     * Получение рубрик
     * @return array массив ответа сервера с данными
     */
    public function actionGetRubrics(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $rubricId = Yii::$app->request->get('rubric_id');
        
        if(empty($rubricId)){
            $rubricId = RubricsHelper::MAIN_PARENT_ID;
        }
        
        $childrens = (new RubricsHelper)->getChildrens($rubricId);
        
        return self::getResponseOk($childrens);
    }

    /**
     * Получение новостей по рубрикам
     * @return array массив ответа сервера с данными
     */
    public function actionGetNews(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $rubricId = Yii::$app->request->get('rubric_id');
        
        if(empty($rubricId)){
            $rubricId = RubricsHelper::MAIN_PARENT_ID;
        }
        
        $newsRubrics = NewsRubricsHelper::getNewsByRubricId($rubricId);

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
