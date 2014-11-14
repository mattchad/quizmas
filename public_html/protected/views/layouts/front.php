<?php $this->beginContent('//layouts/main'); ?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/_css/front.css'); ?>
    <?php echo $content; ?>
<?php $this->endContent(); ?>