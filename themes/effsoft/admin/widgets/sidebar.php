<?php
    use yii\helpers\Url;
?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=Url::to(['/admin/dashboard'], true);?>">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3"><?= Yii::t('app', 'EFF SOFT');?></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="<?=Url::to(['/admin/dashboard'], true);?>">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span><?=Yii::t('app','Dashboard');?></span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    <?=Yii::t('app','Administrator');?>
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link" href="<?=Url::to(['/user/admin/manage'], true);?>">
      <i class="fas fa-fw fa-user"></i>
      <span><?=Yii::t('app','User');?></span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?=Url::to(['/role/admin/manage'], true);?>">
      <i class="fas fa-fw fa-user-tag"></i>
      <span><?=Yii::t('app','Role');?></span></a>
  </li>
  
  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    <?=Yii::t('app','Site');?>
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSitePage" aria-expanded="true" aria-controls="collapseSitePage">
      <i class="fas fa-fw fa-file-import"></i>
      <span><?=Yii::t('app','Page');?></span>
    </a>
    <div id="collapseSitePage" class="collapse">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="<?=Url::to(['/site/admin/page/manage'], true);?>"><?=Yii::t('app','All');?></a>
        <a class="collapse-item" href="<?=Url::to(['/site/admin/page/create'], true);?>"><?=Yii::t('app','Create');?></a>
      </div>
    </div>
  </li>

  <!-- Heading -->
  <div class="sidebar-heading">
  <?=Yii::t('app','Content');?>
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCotentCateogry"
     aria-expanded="true" aria-controls="collapseCotentCateogry">
      <i class="fas fa-fw fa-list"></i>
      <span><?=Yii::t('app','Category');?></span>
    </a>
    <div id="collapseCotentCateogry" class="collapse">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="<?=Url::to(['/content/admin/category/manage'], true);?>"><?=Yii::t('app','All');?></a>
        <a class="collapse-item" href="<?=Url::to(['/content/admin/category/create'], true);?>"><?=Yii::t('app','Create');?></a>
      </div>
    </div>
  </li>
  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseContentPage" aria-expanded="true" aria-controls="collapseContentPage">
      <i class="fas fa-fw fa-file-alt"></i>
      <span><?=Yii::t('app','Document');?></span>
    </a>
    <div id="collapseContentPage" class="collapse">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header"><?=Yii::t('app','Shortcut:');?></h6>
        <a class="collapse-item" href="<?=Url::to(['/content/admin/document/list'], true);?>"><?=Yii::t('app','All');?></a>
        <a class="collapse-item" href="<?=Url::to(['/content/admin/document/create'], true);?>"><?=Yii::t('app','Create');?></a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->