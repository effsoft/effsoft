<?php

$this->context->layout = '@app/views/layouts/admin.layout.php';
$this->title = \Yii::t('app', 'Category Management');
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
                'id' => 'category_form',
                'action' => '',
                'options' => [
                    'autocomplete' => 'off',
                ],
            ])
            ?>
            <div class="form-group">
                <?= $form->field($category_form, 'name', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                ])
                    ->textInput()
                    ->input('name', ['placeholder' => "分类名"])->label(false)->hint(false);
                ?>
            </div>
            <div class="form-group">
                <?php $category_model = new \effsoft\eff\module\content\models\CategoryModel(); ?>
                <?= $form->field($category_form, 'parent_id', [])
                    ->dropDownList(
                        $category_model->getParentDropdownCategories(),
                        [
                            'prompt' => '上级分类',
                            'options' => [
                                \effsoft\eff\helpers\Ids::encodeId($category_form->parent_id) => ['selected' => true],
                            ],
                        ]
                    )->label(false)->hint(false);
                ?>
            </div>
            <div class="form-group">
                <?= $form->field($category_form, 'description', [
                    'inputOptions' => [
                        'class' => 'form-control',
                        'rows' => 5,
                        'placeHolder' => '简介',
                    ],
                ])
                    ->textarea()
                    ->label(false)
                    ->hint(false);
                ?>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
            <?php if (!empty($category_form->errors)): ?>
                <ul class="form_errors mt-2">
                    <?php foreach ($category_form->errors as $error): ?>
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