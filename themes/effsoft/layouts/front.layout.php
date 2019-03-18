<?php
\effsoft\eff\asset\jquery\JqueryAssetBundle::register($this);
\effsoft\eff\asset\bootstrap\bundle\BootstrapBundleAssetBundle::register($this);
\effsoft\eff\asset\jquery\easing\JqueryEasingAssetBundle::register($this);
\effsoft\eff\asset\magnific\popup\MagnificPopupAssetBundle::register($this);
\effsoft\eff\theme\creative\BootstrapCreativeCustomAssetBundle::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= \Yii::$app->language; ?>">
<head>
    <meta charset="<?= \Yii::$app->charset; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.png">
    <?=\yii\helpers\Html::csrfMetaTags();?>
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <?php $this->head() ?>
    <title><?= \yii\helpers\Html::encode($this->title); ?></title>
</head>
<body>
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

