<?php
namespace frontend\controllers;

use Yii;
use yii\base\Controller;
use yii\web\Response;
use common\helpers\RubricsHelper;
use common\helpers\NewsRubricsHelper;

/**
 * News controller
 * Отвечает за отображение новостей
 */
class NewsController extends Controller
{
    /**
     * Родительская рубрика
     */
    const PARENT_RUBRIC = 0;
    
    /**
     * Главная страница новостей
     * @return mixed
     */
    public function actionIndex()
    {
        $rubrics = (new RubricsHelper)->getChildrens(self::PARENT_RUBRIC);
        
        return $this->render('index',
                            ['rubrics' => $rubrics]
                );
    }
    
    /**
     * Возвращает по Ajax запросу список новостей рубрики
     * @return mixed
     */
    public function actionAjaxGetNews()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(!Yii::$app->request->isAjax){
            return ;
        }
        
        $rubricId       = Yii::$app->request->get('rubricId');
        if(empty($rubricId)){
            return ['error'     => true, 
                    'message'   => 'Empty rubricId value'];
        }
        
        $newsRubrics    = NewsRubricsHelper::getNewsByRubricId($rubricId);

        return ['error'   => false, 
                'data'    => $newsRubrics];
    }
}
