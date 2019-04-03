<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= \Yii::$app->language; ?>">
<head>
    <meta charset="<?= \Yii::$app->charset; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.png">
    <?=\yii\helpers\Html::csrfMetaTags();?>

    <link href="/themes/effsoft/fontawesome/css/all.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

    <link href="/themes/effsoft/jquery.magnific-popup/magnific-popup.css" rel="stylesheet">
    <link href="/themes/effsoft/bootstrap-creative/css/creative.min.css" rel="stylesheet">
    <link href="/themes/effsoft/css/custom.css?=<?=time()?>" rel="stylesheet">

    <script src="/themes/effsoft/jquery/jquery.min.js"></script>
    <script src="/themes/effsoft/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/themes/effsoft/jquery.easing/jquery.easing.min.js"></script>
    <script src="/themes/effsoft/jquery.magnific-popup/jquery.magnific-popup.js"></script>
    <script src="/themes/effsoft/chart.js/Chart.min.js"></script>

    <?php $this->head() ?>
    <title><?= \yii\helpers\Html::encode($this->title); ?></title>
</head>
<body>
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>

<script src="/themes/effsoft/bootstrap-creative/js/creative.min.js"></script>
<script src="/themes/effsoft/js/custom.js?v=<?=time()?>"></script>
</body>
</html>
<?php $this->endPage() ?>

