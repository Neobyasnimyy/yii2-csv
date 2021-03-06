<?php

use kartik\slider\Slider;
use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PeopleSearch */
/* @var $form yii\widgets\ActiveForm */
/** @var array $categories */

?>

<div class="people-search">

    <?php $form = ActiveForm::begin([
        'id' => 'people-search',
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'category_id')
        ->label(Yii::t('views', 'Category'))
        ->dropDownList(
            [0 => Yii::t('views', 'All')] + $categories,
            [
                'prompt' => Yii::t('views', 'Select a category...')
            ]
        ); ?>

    <?= $form->field($model, 'gender')->dropDownList(
        [
            0 => Yii::t('views', 'All'),
            1 => 'male',
            2 => 'female'
        ],
        [
            'prompt' => Yii::t('views', 'Select gender...')

        ]) ?>

    <?= '<label class="control-label" for="peoplesearch-birthdate">'
    . $model->getAttributeLabel('birthDate') . '</label>'; ?>

    <?= DatePicker::widget([
        'model' => $model,
        'attribute' => 'birthDate',
        'name' => 'birthDate',
        'type' => DatePicker::TYPE_INPUT,
//        'value' => '04-Feb-2003',
        'options' => [
            'autocomplete' => 'off',
            'placeholder' => Yii::t('views', 'Choose your date of birth ...')
        ],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>

    <?= $form->field($model, 'age')
        ->textInput(['type' => 'number', 'placeholder' => Yii::t('views', 'Enter age ...')]) ?>

  <div class="form-group">
      <?= '<label class="control-label" for="age-interval">'
      . $model->getAttributeLabel('age_interval') . '</label><br>'; ?>

      <?= '<b class="badge">10</b> ' . Slider::widget([
          'id' => 'age-interval',
          'model' => $model,
          'attribute' => 'age_interval',
          'name' => 'age_interval',
//            'value' => '18,25',
          'sliderColor' => Slider::TYPE_GREY,
          'pluginOptions' => [
              'min' => 10,
              'max' => 100,
              'step' => 1,
              'range' => true
          ],
      ]) . ' <b class="badge">100</b>';
      ?>
  </div>


  <div class="form-group">
      <?= Html::submitButton(Yii::t('views', 'Search'), ['class' => 'btn btn-primary']) ?>
      <?= Html::a(Yii::t('views', 'Reset'), [Yii::$app->getHomeUrl()], ['class' => 'btn btn-danger']) ?>
  </div>

    <?php ActiveForm::end(); ?>

</div>
