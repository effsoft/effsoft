<?php
$this->context->layout = '@app/views/layouts/admin.layout.php';
$this->title = Yii::t('app', 'Create Document');
?>
<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button"
       aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">
            <?= Yii::t('app', 'Create Document'); ?>
        </h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="collapseCardExample">
        <div class="card-body">

            <form method="post" action="" autocomplete="off">

                <div class="form-group">
                    <input type="text" class="form-control" name="title" value="" placeholder="标题"/>
                </div>

                <div class="form-group">
                    <textarea name="description" rows="5" class="form-control" placeholder="简介"></textarea>
                </div>

                <div class="form-group">
                    <?= \effsoft\eff\widgets\TinymceWidget::widget(['name' => 'asdf']); ?>
                </div>

            </form>

        </div>
    </div>
</div>