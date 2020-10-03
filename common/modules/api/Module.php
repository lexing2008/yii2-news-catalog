<?php

namespace common\modules\api;

use Yii;

/**
 * Api module definition class
 * Модуль реализует Rest api
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        
        // отключаем сессии
        \Yii::$app->user->enableSession = false;
    }
}
