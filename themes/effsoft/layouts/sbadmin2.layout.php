
<?php
\yii\web\JqueryAsset::register($this);
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

    <?php $this->head() ?>

    <link href="/themes/effsoft/fontawesome/css/all.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

    <link href="/themes/effsoft/jquery.magnific-popup/magnific-popup.css" rel="stylesheet">
    <link href="/themes/effsoft/tokenfield/css/bootstrap-tokenfield.min.css" rel="stylesheet">
    <link href="/themes/effsoft/lightbox2/css/lightbox.min.css" rel="stylesheet">

    <link href="/themes/effsoft/bootstrap-sb-admin-2/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/themes/effsoft/css/custom.css?=<?=time()?>" rel="stylesheet">

    <script src="/themes/effsoft/jquery-ui/jquery-ui.min.js"></script>
    <script src="/themes/effsoft/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/themes/effsoft/md5/md5.min.js"></script>
    <script src="/themes/effsoft/jquery.easing/jquery.easing.min.js"></script>
    <script src="/themes/effsoft/jquery.magnific-popup/jquery.magnific-popup.js"></script>
    <script src="/themes/effsoft/chart.js/Chart.min.js"></script>
    <script src="/themes/effsoft/tinymce/tinymce.min.js"></script>
    <script src="/themes/effsoft/jquery.fileupload/jquery.fileupload.js"></script>
    <script src="/themes/effsoft/tokenfield/bootstrap-tokenfield.min.js"></script>
    <script src="/themes/effsoft/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="/themes/effsoft/lightbox2/js/lightbox.min.js"></script>

    <script src="/themes/effsoft/bootstrap-sb-admin-2/js/sb-admin-2.min.js"></script>
    <script src="/themes/effsoft/js/custom.js?v=<?=time()?>"></script>

    <title><?= \yii\helpers\Html::encode($this->title); ?></title>
</head>
<body>
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

