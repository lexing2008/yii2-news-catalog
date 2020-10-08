<?php
namespace common\helpers;

use Yii;
use common\models\db\Rubrics;


/**
 * Хэлпер RubricsHelper
 * позволяет работать с иерархическим списком рубрик
 */
class RubricsHelper 
{
    /**
     * ID главного родителя в иерархии
     */
    const MAIN_PARENT_ID = 0;
    
    /**
     * Категориии  расположенные как в БД
     * @var array 
     */
    public $original;
    
    /**
     * Категории
     * @var array 
     */
    public $category;
    
    /**
     * Упорядоченные по дереву элементы
     * @var array
     */
    public $items;
    
    /**
     * Количество элементов в $items. Вычисляется как счетчик. используется как счетчик
     * @var int
     */
    protected $currentCountItems = 0;
         
    /**
     * Конструктор класса
     * @param bool $autoLoadFromTable автоматическая загрука из БД при создании объекта
     */
    public function __construct(bool $autoLoadFromTable = true) 
    {
        // подгружаем всю информацию
        if ($autoLoadFromTable){
            $this->loadFromTable();
        }
    }

    /**
     * Загрузка информации из БД и формирование правильной иерархической структуры
     */
    public function loadFromTable() {
        
        $records = Rubrics::find()->asArray()
                                  ->all();
        $rows = count($records);
        unset($this->category);
        unset($this->original);
        unset($this->items);
        $this->category = [];
        for ($i = 0; $i < $rows; $i++) {
            $this->category[$records[$i]['id']] = $records[$i];
        }

        $this->original = $this->category;
        // устанавливаем текущее количество в нуль
        $this->currentCountItems = 0;
        $this->nextItem( self::MAIN_PARENT_ID ); // (Родитель) pid = 0; (Уровень вложенности) level = 0; Начинаем отсчет уровня вложенности	
    }
    
    
    /**
     * Функция находит все элементы родителя
     * @param int $pid идентификатор родителя. Для самого верхнего это 0
     * @param int $level уровень вложенности
     */
    private function nextItem(int $pid, int $level = 0) 
    {
        if(empty($this->category)){
            return;
        }
        // просматриваем весь массив
        foreach ($this->category as $key => $val) {
            // элемент пренадлежит родителю
            if ($val['pid'] == $pid) {
                // добавляем текущий элемент в наш массив упорядоченных элементов
                $this->items[$this->currentCountItems]          = $val;
                $this->items[$this->currentCountItems]['level'] = $level;
                // удаляем текущий элемент из массива
                unset($this->category[$key]);
                // увеличивае счетчик
                $this->currentCountItems++;
                // рекурсивно ищем потомков для данного
                $this->nextItem($key, $level + 1);
            }
        }
    }
    
    /** 
     * Возвращает массив потомков заданного элемента
     * @param int $parent  идентификатор родителя. Приведен к int.
     * @return array массив потомков
     */
    public function getChildrens(int $parent) 
    {
        if($parent == self::MAIN_PARENT_ID){
            return $this->items;
        }
        
        $arr        = [];
        $flagLevel  = 0;
        for ($i = 0; $i < count($this->items); $i++) {
            if ($this->items[$i]['id'] == $parent) {
                $flagLevel = $this->items[$i]['level'];
                ++$i;
                while ($i < count($this->items) && $this->items[$i]['level'] > $flagLevel) {
                    $arr[] = $this->items[$i];
                    ++$i;
                }
                return $arr;
            }
        }
        return $arr;
    }
}
