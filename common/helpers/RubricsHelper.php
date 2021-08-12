<?php
namespace common\helpers;

use common\models\db\Rubrics;

/**
 * Хэлпер RubricsHelper
 * позволяет работать с иерархическим списком рубрик
 */
class RubricsHelper extends HierarchyHelper
{
    /**
     * Имя директории кэша
     */
    const CACHE_DIR_NAME = 'cache/rubrics/';
    
    /**
     * Имя файла кэша
     */
    const CACHE_FILE_NAME = 'rubrics.dat';
    
    /**
     * Получение элементов иерархического списка из кэша
     * @return array элементы иерархического списка
     */
    public function getItemsFromCache(): array 
    { 
        $items = [];
        // путь к файлу кэша
        $path = $this->getCachePath();
        // проверяем существование файла
        if(file_exists($path)){
            // получаем элементы иерархического списка
            $items = json_decode(file_get_contents($path), true);
        }
        
        return $items; 
    }
    
    /**
     * Получение элементов иерархического списка из таблицы
     * @return array массив элементов иерархического списка
     */
    public function getItemsFromTable(): array
    {
        return Rubrics::find()->asArray()->all();        
    }
    
    /**
     * Сохранение элементов иерархического списка в кэш
     */
    public function saveItemsToCache()
    {
        // преобразуем массив элементов иерархического списка в json
        $content = json_encode($this->items);
        // записываем кэш в файл
        file_put_contents($this->getCachePath(), $content);
    }
}