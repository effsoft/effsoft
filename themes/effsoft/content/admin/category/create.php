<?php

use yii\widgets\LinkPager;
use effsoft\eff\module\passport\services\UserService;
use yii\widgets\Breadcrumbs;
use effsoft\eff\asset\tinymce\TinymceAssetBundle;

TinymceAssetBundle::register($this);

$this->context->layout = '@app/themes/effsoft/admin/layouts/admin.layout.php';
$this->title = \Yii::t('app', 'User Management');
?>

