<?php

use yii\widgets\LinkPager;
use effsoft\eff\module\passport\services\UserService;
use yii\widgets\Breadcrumbs;
use effsoft\eff\asset\tinymce\TinymceAssetBundle;
use effsoft\eff\module\content\modules\admin\models\CategoryModel;

TinymceAssetBundle::register($this);

$this->context->layout = '@app/themes/effsoft/admin/layouts/admin.layout.php';
$this->title = \Yii::t('app', 'User Management');
?>

<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button"
       aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Create Category</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="collapseCardExample">
        <div class="card-body">
            <?php

            use yii\widgets\ActiveForm;

            $form = ActiveForm::begin([
                'id' => 'category_create_form',
                'action' => \yii\helpers\Url::to(['/content/admin/category/create']),
                'options' => [
                    'autocomplete' => 'off',
                ],
            ])
            ?>
            <div class="form-group">
                <?= $form->field($category_create_form, 'name', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                ])
                    ->textInput()
                    ->input('name', ['placeholder' => "分类名"])->label(false)->hint(false);
                ?>
            </div>
            <div class="form-group">
                <?php $category_model = new CategoryModel(); ?>
                <?= $form->field($category_create_form, 'parent_id', [])
                    ->dropDownList(
                        $category_model->getDropdownCategories(),
                        [
                            'prompt' => '上级分类',
                        ],
                        [
                            'options' => ['0' => ['Selected' => true]],
                        ]
                    )->label(false)->hint(false);
                ?>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
            <?php if (!empty($category_create_form->errors)): ?>
                <ul class="form_errors mt-2">
                    <?php foreach ($category_create_form->errors as $error): ?>
                        <?php if (!empty($error)): ?>
                            <?php foreach ($error as $val): ?>
                                <li><?= $val ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div> 