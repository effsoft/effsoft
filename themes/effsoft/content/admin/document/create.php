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
                'enableAjaxValidation' => true,
                'validationUrl' => \yii\helpers\Url::to(['/content/admin/document/validate', 'a' => 'create']),
            ])
            ?>

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
                <?= $form->field($document_form, 'author', [
                    'inputOptions' => [
                        'class' => 'form-control author'
                    ],
                ])
                    ->textInput()
                    ->input('text', ['placeholder' => "作者"])->label(false)->hint(false);
                ?>
            </div>

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" onclick="return upload_cover();">上传封面图
                        </button>
                    </div>
                    <input type="text" class="form-control" placeholder="..." disabled>
                    <?= $form->field($document_form, 'cover', [])
                        ->hiddenInput()->label(false)->hint(false);
                    ?>
                </div>
                <div id="cover_preview" class="mt-2">

                </div>
            </div>

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" onclick="return upload_carousel();">
                            上传轮播图
                        </button>
                    </div>
                    <input type="text" class="form-control" placeholder="..." disabled>
                </div>
                <div id="carousel_preview" class="position-relative">

                </div>
            </div>

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
                        'options' => ['name' => 'DocumentForm[content]'],
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
<script type="text/javascript">

    $(function () {
        $('.author').tokenfield({createTokensOnBlur: true});
    });

    var upload_cover = function () {
        var accept = 'image/*';
        var uuid = get_uuid();
        var form = $('<form>').attr({
            'enctype': 'multipart/form-data',
            'action': '<?=\yii\helpers\Url::to(['/media/upload/image']);?>',
            'type': 'post',
        }).append($('<input>').attr({
            'type': 'hidden',
            'name': 'uuid',
            'value': uuid,
        })).append($('<input>').attr({
            'type': 'hidden',
            'name': 'media_type',
            'value': <?=\effsoft\eff\module\media\enums\MediaType::DOCUMENT_COVER_IMAGE;?>,
        })).append($('<input>').attr({
            'type': 'hidden',
            'name': '_csrf',
            'value': $('meta[name="csrf-token"]').attr("content"),
        })).append($('<input>').attr({
            'type': 'file',
            'name': 'file',
            'accept': accept,
        }));
        form.fileupload({
            dataType: 'json',
            maxChunkSize: 1 * 1024 * 1024, // 1 MB
            maxFileSize: 20 * 1024 * 1024,
            maxRetries: 5,
            retryTimeout: 5 * 1000,
            formData: form.serializeArray(),
            add: function (e, data) {
                console.log('add');
                console.log(get_tinymce_element_identity(uuid, data.files[0].name));
                $('#cover_preview').html('');
                $('input[id=documentform-cover]').val('');
                var that = this;
                $.postJSON('<?=\yii\helpers\Url::to(['/media/upload/chunk']);?>', {
                    uuid: uuid,
                    file_name: data.files[0].name
                }, function (result) {
                    var file = result.file;
                    data.uploadedBytes = file && file.size;
                    $.blueimp.fileupload.prototype.options.add.call(that, e, data);
                });
            },
            submit: function (e, data) {
                console.log('submit');

                $('#cover_preview').html(get_tinymce_loading(get_tinymce_element_identity(uuid, data.files[0].name)));
            },
            send: function (e, data) {
                console.log('send');
            },
            done: function (e, data) {
                console.log('done');
                var $body = $('#cover_preview');

                var response = data.result;
                var file = data.result.file[0];
                if (file.error != undefined) {
                    $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name))
                        .replaceWith($('<div style="color:#ff5e3a;">' + file.error + '</div>').fadeOut(5000, function () {
                            $(this).remove();
                        }));
                    return;
                }
                $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name))
                    .replaceWith($('<div id="' + get_tinymce_element_identity(uuid, data.files[0].name) + '">' +
                        '<a href="#" onclick="return upload_cover();"><img src="' + file.smallUrl + '" /></a>' +
                        '</div>'));
                $('input[id=documentform-cover]').val(file._id);
            },
            fail: function (e, data) {
                console.log('fail');
                var $body = $('#cover_preview');
                $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name))
                    .find('span[class="percent"]')
                    .addClass('text-danger')
                    .text('Error, please try again!');
                $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name)).fadeOut(1000);
            },

            progress: function (e, data) {
                console.log('progress');
                var progress = parseInt(data.loaded / data.total * 100, 10);
                var $body = $('#cover_preview');
                $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name))
                    .find('.progress-bar')
                    .css('width', progress + '%')
                    .attr('aria-valuenow', progress);
                if (progress == 100) {
                    $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name)).find('span[class="percent"]').html('Processing...');
                } else {
                    $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name)).find('span[class="percent"]').html(progress + '%');
                }
            },
        });
        form.find('input[type="file"]').click();
        return false;
    };

    var upload_carousel = function () {
        var accept = 'image/*';
        var uuid = get_uuid();
        var form = $('<form>').attr({
            'enctype': 'multipart/form-data',
            'action': '<?=\yii\helpers\Url::to(['/media/upload/image']);?>',
            'type': 'post',
        }).append($('<input>').attr({
            'type': 'hidden',
            'name': 'uuid',
            'value': uuid,
        })).append($('<input>').attr({
            'type': 'hidden',
            'name': 'media_type',
            'value': <?=\effsoft\eff\module\media\enums\MediaType::DOCUMENT_COVER_IMAGE;?>,
        })).append($('<input>').attr({
            'type': 'hidden',
            'name': '_csrf',
            'value': $('meta[name="csrf-token"]').attr("content"),
        })).append($('<input>').attr({
            'type': 'file',
            'name': 'file',
            'accept': accept,
            'multiple': 'multiple',
        }));
        form.fileupload({
            dataType: 'json',
            maxChunkSize: 1 * 1024 * 1024, // 1 MB
            maxFileSize: 20 * 1024 * 1024,
            maxRetries: 5,
            retryTimeout: 5 * 1000,
            formData: form.serializeArray(),
            add: function (e, data) {
                console.log('add');
                console.log(get_tinymce_element_identity(uuid, data.files[0].name));
                var that = this;
                $.postJSON('<?=\yii\helpers\Url::to(['/media/upload/chunk']);?>', {
                    uuid: uuid,
                    file_name: data.files[0].name
                }, function (result) {
                    var file = result.file;
                    data.uploadedBytes = file && file.size;
                    $.blueimp.fileupload.prototype.options.add.call(that, e, data);
                });
            },
            submit: function (e, data) {
                console.log('submit');

                $('#carousel_preview').append(get_tinymce_loading(get_tinymce_element_identity(uuid, data.files[0].name)));
            },
            send: function (e, data) {
                console.log('send');
            },
            done: function (e, data) {
                console.log('done');
                var $body = $('#carousel_preview');

                var response = data.result;
                var file = data.result.file[0];
                if (file.error != undefined) {
                    $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name))
                        .replaceWith($('<div style="color:#ff5e3a;">' + file.error + '</div>').fadeOut(5000, function () {
                            $(this).remove();
                        }));
                    return;
                }
                $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name))
                    .replaceWith($('<div class="float-left m-3 mt-0 position-relative border rounded p-2" id="' + get_tinymce_element_identity(uuid, data.files[0].name) + '">' +
                        '<a href="#" onclick="return del_carousel(this);" class="text-danger" style="position:absolute;right:-10px;top:-10px;"><i class="fa fa-fw fa-times"></i></a>' +
                        '<a href="#" onclick="return upload_carousel();"><img src="' + file.smallUrl + '" /></a>' +
                        '<input type="hidden" name="DocumentForm[carousel][]" value="' + file._id + '" />' +
                        '</div>'));

            },
            fail: function (e, data) {
                console.log('fail');
                var $body = $('#carousel_preview');
                $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name))
                    .find('span[class="percent"]')
                    .addClass('text-danger')
                    .text('Error, please try again!');
                $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name)).fadeOut(1000);
            },

            progress: function (e, data) {
                console.log('progress');
                var progress = parseInt(data.loaded / data.total * 100, 10);
                var $body = $('#carousel_preview');
                $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name))
                    .find('.progress-bar')
                    .css('width', progress + '%')
                    .attr('aria-valuenow', progress);
                if (progress == 100) {
                    $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name)).find('span[class="percent"]').html('Processing...');
                } else {
                    $body.find('#' + get_tinymce_element_identity(uuid, data.files[0].name)).find('span[class="percent"]').html(progress + '%');
                }
            },
        });
        form.find('input[type="file"]').click();
        return false;
    };

    var del_carousel = function (e) {
        var $obj = $(e);
        $obj.parent().remove();
        return false;
    };

    $(function () {
        $(document).on('beforeSubmit', 'form#document_form', function () {
            var form = $(this);
            //返回错误的表单信息
            if (form.find('.has-error').length) {
                return false;
            }
            //表单提交
            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function (response) {
                    if (response.status == 0) {
                        window.location.href = '<?=\yii\helpers\Url::to(['/content/admin/document/manage'])?>';
                    }else{
                        $.notify({
                            message: response.message,
                        },{
                            type: 'danger'
                        });
                    }
                },
                error: function () {
                    $.notify({
                        message: 'System error!'
                    },{
                        type: 'danger'
                    });
                    return false;
                }
            });
            return false;
        });
    });
</script>