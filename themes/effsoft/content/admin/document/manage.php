<?php
$this->context->layout = '@app/views/layouts/admin.layout.php';
$this->title = Yii::t('content/app', 'Manage Document');
?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= \Yii::t('content/app', 'Documents'); ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive position-relative">
                <div class="container-fluid">
                    <?php
                    $query = \effsoft\eff\module\content\models\DocumentModel::find()->orderBy(['_id' => SORT_DESC]);
                    $totalCount = $query->count();
                    $pagination = new \yii\data\Pagination(['totalCount' => $totalCount]);
                    // $pagination->setPageSize(1);
                    $documents = $query->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();
                    ?>

                    <?php
                    $categories = \effsoft\eff\module\content\models\CategoryModel::find()->orderBy(['_id' => SORT_DESC])->all();
                    ?>
                    <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0"
                           role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                        <thead>
                        <tr role="row">
                            <th>
                                类别
                            </th>
                            <th>
                                封面
                            </th>
                            <th>
                                标题
                            </th>
                            <th>
                                作者
                            </th>
                            <th>
                                简介
                            </th>
                            <th>
                                创建时间
                            </th>
                            <th>
                                操作
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($documents as $document): ?>
                            <tr>
                                <td>
                                    <?= \effsoft\eff\module\content\services\CategoryService::get_category($document->category, $categories)->name; ?>
                                </td>
                                <td>
                                    <a href="<?= \effsoft\eff\module\media\services\MediaUrlService::get_thumbnail($document->cover['url'],'large'); ?>"
                                       data-title="<?= $document->subject; ?>"
                                       data-lightbox="cover">
                                        <img src="<?= \effsoft\eff\module\media\services\MediaUrlService::get_thumbnail($document->cover['url']); ?>"/>
                                    </a>
                                </td>
                                <td>
                                    <a target="_blank"
                                       href="<?= \yii\helpers\Url::to(['/content/document/detail', 'doc' => \effsoft\eff\helpers\Ids::encodeId($document->_id)]) ?>">
                                        <?= $document->subject; ?>
                                    </a>
                                </td>
                                <td>
                                    <span><?= $document->author; ?></span>
                                </td>
                                <td>
                                    <span><?= $document->introduction; ?></span>
                                </td>
                                <td>
                                    <span><?= date('m/d/Y', $document->date_created); ?></span>
                                </td>
                                <td>
                                    <a href="#">
                                        <i class="fa fa-fw fa-edit"></i>
                                    </a>
                                    <a href="#">
                                        <i class="fa fa-fw fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?= \yii\widgets\LinkPager::widget([
    'pagination' => $pagination,
    'pageCssClass' => 'paginate_button page-item',
    'linkOptions' => [
        'class' => 'page-link',
    ],
    'disabledListItemSubTagOptions' => [
        'tag' => 'a',
    ],
    'disabledPageCssClass' => 'page-link',
    'prevPageCssClass' => 'paginate_button page-item previous',
    'prevPageLabel' => '上一页',
    'nextPageCssClass' => 'paginate_button page-item',
    'nextPageLabel' => '下一页',
]); ?>
<script type="text/javascript">
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })
</script>
