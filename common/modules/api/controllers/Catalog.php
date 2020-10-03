<?php

namespace common\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use common\helpers\RubricsHelper;

use common\modules\adv\helpers\yandex\CampaignHelper as YandexCampaignHelper;
use common\modules\adv\helpers\google\CampaignHelper as GoogleCampaignHelper;
use common\modules\api\helpers\ReportTextContextualAdvertisingHelper as ReportTextHelper;
use common\helpers\SlackHelper;

/**
 * Controller for the `Api` module
 * Контреллер Api для управления контекстной рекламой
 */
class ContextualAdvertisingController extends Controller
{
    
    /**
     * Максимальное время выполнения скрипта в секундах
     */
    const MAX_EXECUTION_TIME = 150;
    
    /**
     * Время выполнения для одного города в секундах
     */
    const EXECUTION_TIME_ONE_CITY = 15;
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['verbs'] = [
                'class'     => \yii\filters\VerbFilter::class,
                'actions'   => [
                    'get-news-by-rubric'    => ['GET'],
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
        
        return self::getResponseOk($data);
    }

    /**
     * Выключение рекламных кампаний по городам
     * @return string
     */
    public function actionDisableCampaignsByCities(): array
    {
        $cities = Yii::$app->request->getBodyParam('cities');
        
        if(empty($cities)){
            return self::getResponseBadRequest();
        }

	// необходимо увеличить время выполнения скрипта
	set_time_limit(self::MAX_EXECUTION_TIME + count($cities) * self::EXECUTION_TIME_ONE_CITY );
        
        // получаем настройки аккаунтов Google Ads и Yandex Direct
        $settingsGoogle     = Yii::$app->getModule('adv')->googleAds;
        $settingsYandex     = Yii::$app->getModule('adv')->yandexDirect;

        // отключаем рекламные кампании
        $log =  GoogleCampaignHelper::make([], array_shift($settingsGoogle))->connect()->disableCampaignsByCities($cities);
        $log .=  GoogleCampaignHelper::make([], array_shift($settingsGoogle))->connect()->disableCampaignsByCities($cities);
        $log .=  YandexCampaignHelper::make([], array_shift($settingsYandex))->connect()->disableCampaignsByCities($cities);

        // отправляем отчет в слек
        if(!empty($log)){
            SlackHelper::notifyMarketingDirect( ReportTextHelper::make()->reportDisableCampaignsByCities($cities, $log) );
        }
        
        return self::getResponseOk($log);
    }
    
    /**
     * Возвращает ответ 400 Bad Request
     * @return array данные
     */
    public static function getResponseBadRequest(): array
    {
        return [
                    'status'    => 400,
                    'name'      => 'Bad Request',
                    'message'     => 'Empty data. Variable "cities" is empty.'
                ];        
    }
    
    /**
     * Возвращает ответ 200 OK
     * @return array данные
     */
    public static function getResponseOk(string $data): array
    {
        return [    
                    'status'    => 200,
                    'name'      => 'ok',
                    'message'   => 'Operation completed successfully.',
                    'data'      => $data
                ];
    }
}
