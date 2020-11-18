<?php

use app\models\PeopleSearch;
use app\models\UploadCsv;
use kartik\export\ExportMenu;
use kartik\file\FileInput;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/** @var $modelUploadCsv UploadCsv */
/* @var $searchModelPeople app\models\PeopleSearch */
/* @var $dataProviderPeople yii\data\ActiveDataProvider */
/** @var array $categories */

$this->title = 'CSV-Yii2';
?>

<div class="site-index">
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['site/upload']),
        'method' => 'post',
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]) ?>

    <?= $form->field($modelUploadCsv, 'uploadedFile')->fileInput() ?>

  <button type="submit" class="btn btn-primary">Send</button>

    <?php ActiveForm::end() ?>
  <br>
  <div class="people">

      <?php
      $gridColumns = [
          [
              'attribute' => 'Category',
              'value' => function ($data) use ($categories) {
                  return $categories[$data->category_id];
              },
          ],
          'firstname',
          'lastname',
          'email:email',
          [
              'attribute' => 'gender',
              'value' => function ($data) {
                  return ($data->gender == 1) ? 'male' : 'female';
              },
          ],
          [
              'attribute' => 'birthDate',
//              'format' => ['date', 'dd-mm-Y']
          ],
      ];

      // Renders a export dropdown menu
      echo ExportMenu::widget([
          'dataProvider' => $dataProviderPeople,
          'columns' => $gridColumns,
          'columnSelectorOptions' => [
              'label' => 'Columns',
              'class' => 'btn btn-danger'
          ],
          'fontAwesome' => true,
          'dropdownOptions' => [
              'label' => 'Export',
              'class' => 'btn btn-primary'
          ],
          'exportConfig' => [
              ExportMenu::FORMAT_HTML => false,
              ExportMenu::FORMAT_TEXT => false,
              ExportMenu::FORMAT_PDF => false,
              ExportMenu::FORMAT_EXCEL => false,
              ExportMenu::FORMAT_EXCEL_X => false,
          ],
      ]);

      ?>

      <?php Pjax::begin(); ?>

      <?php echo $this->render('_search', [
              'model' => $searchModelPeople,
              'categories' => $categories
          ]
      ); ?>

      <?= GridView::widget([
          'dataProvider' => $dataProviderPeople,
//        'filterModel' => $searchModelPeople,
          'columns' => $gridColumns,
      ]); ?>

      <?php Pjax::end(); ?>

  </div>

</div>


