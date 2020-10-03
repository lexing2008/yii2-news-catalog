<?php

/* @var $this yii\web\View */
$this->registerJsFile(
    '@web/js/news.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title = 'News';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Все новости!</h1>

    </div>

    <div>
        <div id="news_menu">
<?php
$count = count($rubrics);
for ($i = 0; $i < $count; ++$i) {
    $it = $rubrics[$i];
?>
        <div class="offset_level_<?=$it['level']?>">
            <a href="news/rubrics/?id=<?=$it['id']?>"><?=$it['title']?></a>
            <input type="hidden" value="<?=$it['id']?>">
        </div>
<?php
}
?>
        </div>
        <div id="news_list">
            Нажмите на любую рубрику слева, чтобы появились новости рубрики
        </div>
        <div class="line"></div>
    </div>
</div>
