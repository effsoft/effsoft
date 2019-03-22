<?php

use yii\widgets\LinkPager;
use effsoft\eff\module\passport\services\UserService;

$this->context->layout = '@app/themes/effsoft/admin/layouts/admin.layout.php';
$this->title = \Yii::t('app', 'User Management');
?>
    <h1 class="h3 mb-2 text-gray-800"><?= \Yii::t('app', 'User'); ?></h1>
    <p class="mb-4"><?= \Yii::t('app', 'User Management'); ?></p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= \Yii::t('app', 'Users'); ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>注册日期</th>
                        <th>激活</th>
                        <th>状态</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = \effsoft\eff\module\passport\models\UserModel::find()->orderBy(['_id' => SORT_DESC]);
                    $totalCount = $query->count();
                    $pagination = new \yii\data\Pagination(['totalCount' => $totalCount]);
                    // $pagination->setPageSize(1);
                    $users = $query->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();
                    ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td>
                                <?= $user->first_name ?>
                            </td>
                            <td>
                                <?= $user->last_name ?>
                            </td>
                            <td>
                                <a href="<?= \yii\helpers\Url::to(['/user/' . UserService::encodeId($user->_id)], true) ?>"
                                   target="_blank">
                                    <?= $user->username ?>
                                </a>
                            </td>
                            <td>
                                <?= $user->email ?>
                            </td>
                            <td>
                                <?= date('m/d/Y', $user->date_created) ?>
                            </td>
                            <td>
                                <?php if ($user->activated) : ?>
                                    <a href="#" class="btn btn-sm btn-success btn-circle" onclick="return false;"
                                       title="已激活">
                                        <i class="fas fa-fw fa-check"></i>
                                    </a>
                                <?php else : ?>
                                    <a href="#" class="btn btn-sm btn-danger btn-circle" onclick="return false;"
                                       title="未激活">
                                        <i class="fas fa-fw fa-exclamation-triangle"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-warning btn-circle" onclick="return false;"
                                       title="发送激活邮件">
                                        <i class="fas fa-fw fa-envelope"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!$user->blocked) : ?>
                                    <a href="#" class="btn btn-sm btn-success btn-circle" onclick="return false;"
                                       title="正常">
                                        <i class="fas fa-fw fa-check"></i>
                                    </a>

                                <?php else : ?>
                                    <a href="#" class="btn btn-sm btn-danger btn-circle" onclick="return false;"
                                       title="被封禁">
                                        <i class="fas fa-fw fa-minus-circle"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= LinkPager::widget([
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

<?php
$this->registerJs(<<< EOT_JS_CODE

  // JS code here

EOT_JS_CODE
);
?>