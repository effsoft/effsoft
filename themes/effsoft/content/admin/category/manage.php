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
                    <div class="row mb-2 p-2 border-bottom" id="<?= $category->_id ?>">
                        <div class="col align-left">
                            <?= $category->name ?>
                        </div>
                        <div class="col">
                            <a href="#" class="btn btn-sm btn-success btn-circle swap_up"
                               data-id="<?=$category->_id?>"
                               data-order="<?=$category->order?>"
                               <?php if (reset($categories) == $category): ?>style="display:none;"<?php endif; ?>
                               title="上移">
                                <i class="fas fa-fw fa-arrow-up"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-success btn-circle swap_down"
                               <?php if (end($categories) == $category): ?>style="display:none;"<?php endif; ?>
                               title="下移">
                                <i class="fas fa-fw fa-arrow-down"></i>
                            </a>
                        </div>
                    </div>
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
        e.find('.swap_up').hide();
    }else{
        e.find('.swap_up').show();
    }
    if(e.is(':last-child')){
        e.find('.swap_down').hide();
    }else{
        e.find('.swap_down').show();
    }
  };

EOT_JS_CODE
);
?>
