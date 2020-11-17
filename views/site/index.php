<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['site/upload']),
        'method' => 'post',
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]) ?>

    <?= $form->field($model, 'uploadedFile')->fileInput() ?>

  <button>Submit</button>

    <?php ActiveForm::end() ?>
</div>
