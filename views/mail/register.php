<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2>This message allows you to visit our site home page by one click</h2>
<p>您的注册码： <?php echo $verify_code; ?></p>
<p><a href="<?php echo $verify_url; ?>">点击完成注册</a></p>
<p>如果您无法点击，请拷贝下面的链接并访问： <?php echo $verify_url; ?></p>
