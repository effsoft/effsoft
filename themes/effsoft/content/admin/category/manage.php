<?php

use yii\widgets\LinkPager;
use effsoft\eff\module\passport\services\UserService;

$this->context->layout = '@app/themes/effsoft/admin/layouts/admin.layout.php';
$this->title = \Yii::t('app', 'Category Management');
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= \Yii::t('app', 'Categories'); ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive position-relative">
            <div class="container-fluid">
                <?php
                $query = \effsoft\eff\module\content\modules\admin\models\CategoryModel::find()->orderBy(['_id' => SORT_DESC]);
                $totalCount = $query->count();
                $pagination = new \yii\data\Pagination(['totalCount' => $totalCount]);
                // $pagination->setPageSize(1);
                $categories = $query->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();
                ?>
                <?php foreach ($categories as $category) : ?>
                    <?php if (empty($category->parent_id)): ?>
                        <div class="row mb-2 p-2 border-bottom category_row" id="<?= $category->_id ?>">
                            <div class="col align-left">
                                <?= $category->name ?>
                                <?php foreach ($categories as $c): ?>
                                    <?php if (strval($c['parent_id']) == strval($category->_id)): ?>
                                        <div class="row category_row p-2">
                                            <div class="col">
                                                -- <?= $c->name ?>
                                            </div>
                                            <div class="col">
                                                <a href="<?= \yii\helpers\Url::to(['/content/admin/category/edit', 'id' => \effsoft\eff\helpers\Ids::encodeId($c->_id)]) ?>"
                                                   class=""
                                                   title="编辑">
                                                    <i class="fa fa-fw fa-edit"></i>
                                                </a>
                                                <a href="<?= \yii\helpers\Url::to(['/content/admin/category/delete', 'id' => \effsoft\eff\helpers\Ids::encodeId($c->_id)]) ?>"
                                                   class=""
                                                   title="删除">
                                                    <i class="fa fa-fw fa-minus"></i>
                                                </a>
                                                <a href="#" class="swap_up"
                                                   data-id="<?= $c->_id ?>"
                                                   data-order="<?= $c->order ?>"
                                                   title="上移">
                                                    <i class="fas fa-fw fa-arrow-up"></i>
                                                </a>
                                                <a href="#" class="swap_down"
                                                   data-id="<?= $c->_id ?>"
                                                   data-order="<?= $c->order ?>"
                                                   title="下移">
                                                    <i class="fas fa-fw fa-arrow-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="col">
                                <a href="<?= \yii\helpers\Url::to(['/content/admin/category/edit', 'id' => \effsoft\eff\helpers\Ids::encodeId($category->_id)]) ?>"
                                   class="btn btn-sm btn-primary btn-circle"
                                   title="编辑">
                                    <i class="fas fa-fw fa-edit"></i>
                                </a>
                                <a href="<?= \yii\helpers\Url::to(['/content/admin/category/delete', 'id' => \effsoft\eff\helpers\Ids::encodeId($category->_id)]) ?>"
                                   class="btn btn-sm btn-danger btn-circle"
                                   title="删除">
                                    <i class="fas fa-fw fa-minus"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-secondary btn-circle swap_up"
                                   data-id="<?= $category->_id ?>"
                                   data-order="<?= $category->order ?>"
                                   title="上移">
                                    <i class="fas fa-fw fa-arrow-up"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-secondary btn-circle swap_down"
                                   data-id="<?= $category->_id ?>"
                                   data-order="<?= $category->order ?>"
                                   title="下移">
                                    <i class="fas fa-fw fa-arrow-down"></i>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
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


  $('.swap_up').click(function(){
    var ele = $(this);
    var parent = ele.parent().closest('div.row');
    var prev = parent.prev();
    parent.swap({  
        target: prev, 
        opacity: "0.5", 
        speed: 500, 
        callback: function() {
            parent.insertBefore(prev);
            parent.attr('style','');
            prev.attr('style','');
            check_swap_position(parent);
            check_swap_position(prev);
        }  
    });  
  });
  
  $('.swap_down').click(function(){
    var ele = $(this);
    var parent = ele.parent().closest('div.row');
    var next = parent.next();
    parent.swap({  
        target: next, 
        opacity: "0.5", 
        speed: 500, 
        callback: function() {
            parent.insertAfter(next);
            parent.attr('style','');
            next.attr('style','');
            check_swap_position(parent);
            check_swap_position(next);
        }  
    });  
  });
  
  var check_swap_position = function(e){
    if(e.is(':first-child')){
        e.children().last().find('.swap_up').hide();
    }else{
        e.children().last().find('.swap_up').show();
    }
    if(e.is(':last-child')){
        e.children().last().find('.swap_down').hide();
    }else{
        e.children().last().find('.swap_down').show();
    }
  };
  
  $(function(){
        $.each($('.category_row'),function(index,value){
            check_swap_position($(value));
        });
    });

EOT_JS_CODE
);
?>
