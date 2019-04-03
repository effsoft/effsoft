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

            <?php

            use yii\widgets\ActiveForm;

            $form = ActiveForm::begin([
                'id' => 'document_form',
                'action' => '',
                'options' => [
                    'autocomplete' => 'off',
                ],
            ])
            ?>

            <div class="form-group">
                <?= $form->field($document_form, 'subject', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                ])
                    ->textInput()
                    ->input('subject', ['placeholder' => "标题"])->label(false)->hint(false);
                ?>
            </div>

            <div class="form-group">
                <?php $category_model = new \effsoft\eff\module\content\models\CategoryModel(); ?>
                <?= $form->field($document_form, 'category', [])
                    ->dropDownList(
                        $category_model->getDropdownCategories(),
                        [
                            'prompt' => '分类',
                        ],
                        [
                            'options' => [$document_form->category => ['Selected' => true]],
                        ]
                    )->label(false)->hint(false);
                ?>
            </div>

            <div class="form-group">
                <?= $form->field($document_form, 'introduction', [
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
                <?= $form->field($document_form, 'content')->widget(\effsoft\eff\widgets\TinymceWidget::class,
                    [
                        'options' => ['name' => 'content'],
                    ])
                    ->label('内容')
                    ->hint(false); ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>

            <?php if (!empty($document_form->errors)): ?>
                <ul class="form_errors mt-2">
                    <?php foreach ($document_form->errors as $error): ?>
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