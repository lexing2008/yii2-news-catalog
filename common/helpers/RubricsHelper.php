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
     * Учитывать только активные
     * @var bool
     */
    protected $active;
    
    /**
     * поля таблицы
     * @var string 
     */
    protected $tableFields;
    
    /**
     * Родительская категория
     * @var type 
     */
    protected $parentId = 0;
       
    /**
     * Поля по умолчанию
     * @var string 
     */
    protected $defaultFields = '`id` , `pid` , `title`, `position`';
    
    /**
     * Разделитель элементов
     * @var string 
     */
    protected $itemSeparator = '- - ';

    /**
     * 
     * @param bool $autoLoadFromTable автоматическая загрука из БД при создании объекта
     * @param string $tableFields извлекаемые поля. Как в SQL: `id`, `name`, `title`
     * @param int $parentId идентификатор родительской категории
     */
    public function __construct(bool $autoLoadFromTable = true, string $tableFields = '', int $parentId = 0) 
    {
        $this->parentId     = $parentId;

        if (empty($tableFields)){
            $this->tableFields = $this->defaultFields;
        } else {
            $this->tableFields = $tableFields;
        }

        // подгружаем всю информацию
        if ($autoLoadFromTable){
            $this->loadFromTable();
        }
    }

    /**
     * Загрузка информации из БД и формирование правильной иерархической структуры
     */
    public function loadFromTable() {
        
        $arrWhere = [];

        if ($this->parentId){
            $arrWhere['pid'] = $this->parentId;
        }

        $records = Rubrics::find()->andWhere( $arrWhere )
                                    ->orderBy('position ASC')
                                    ->asArray()
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
        $this->nextItem( $this->parentId ); // (Родитель) pid = 0; (Уровень вложенности) level = 0; Начинаем отсчет уровня вложенности	
    }
    
    
    /**
     * Функция находит все элементы родителя
     * @param int $pid идентификатор родителя. Для самого верхнего это 0
     * @param int $level уровень вложенности
     */
    private function nextItem(int $pid, int $level = 0) 
    {
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
    
    /*
     * Возвращает данные для dropDownList
     */
    public function getDataForDropDownList()
    {
        $data = [0 => '..родительская категория'];
        // просматриваем весь массив
        foreach ($this->items as $key => $item) {
            $data[ $item['id'] ] = str_repeat($this->itemSeparator, $item['level']) . $item['title'];
        }
        return $data;
    }
    

    /** 
     * Возвращает массив потомков заданного элемента
     * @param int $parent  идентификатор родителя. Приведен к int.
     * @return array массив потомков
     */
    public function getChildrens(int $parent) 
    {
        if($parent == 0){
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