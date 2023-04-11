<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\helpers\Url;
// use app\widgets\Alert;
// use yii\bootstrap5\Breadcrumbs;
// use yii\bootstrap5\Html;
// use yii\bootstrap5\Nav;
// use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->head() ?>
</head>
<?php $this->beginBody(); ?>
<body>
    <header>
        <nav class="flex">
            <div class="logo">
                BIncom Poll App
            </div>

            <ul class="flex-e ul">
                <li class="pu">
                    <a href="<?php echo Url::to(['site/index']);?>" class="pu">Individual polling unit</a>
                </li>

                <li class="pur">
                    <a href="<?php echo Url::to(['site/showres']);?>" class="pur">polling unit result</a>
                </li>

                <li class="ar">
                    <a href="<?php echo Url::to(['site/addres']) ;?>" class="ar">Add new poll result</a>
                </li>
            </ul>
        </nav>
    </header>
    
    <?php echo $content ?>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
