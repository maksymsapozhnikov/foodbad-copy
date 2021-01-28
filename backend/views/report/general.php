<?php

use backend\models\Report;
use backend\models\User;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Report */

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="report-index box box-primary">
	<div class="container-fluid">
		<div class="box-header with-border">
			<h3 class="box-title"></h3>
			<div class="box-tools pull-right">
             <? //= Html::a('<span class="fa fa-refresh"></span>', ['index'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
			</div>
		</div>

		<div class="box-body no-padding">
			<div class="set-param" style="min-height: 260px">
             <?php $form = ActiveForm::begin(['method' => 'GET','id' => 'form-report']) ?>
				<div class="row">
					<div class="col-md-6">
                   <?= $form->field($model, 'suburbIds')->widget(Select2::class, [
                      'data' => $model->suburbsList,
                      'options' => ['placeholder' => 'Please select a suburb', 'multiple' => true],
                      'pluginOptions' => [
                         'tokenSeparators' => [',', ' '],
                         'maximumInputLength' => 10,
                         'allowClear' => true,
                      ],
                   ])->label('Suburbs (for filter "Restaurants")'); ?>
					</div>
					<div class="col-md-6">
                   <?php
                   echo '<label class="control-label">Time Period</label>';
                   echo DatePicker::widget([
                      'model' => $model,
                      'attribute' => 'startDate',
                      'attribute2' => 'endDate',
                      'options' => ['placeholder' => 'Start date'],
                      'options2' => ['placeholder' => 'End date'],
                      'type' => DatePicker::TYPE_RANGE,
                      'form' => $form,
                      'pluginOptions' => [
                         'autoclose' => true,
                         'format' => 'dd-mm-yyyy',
                          //'startDate' => 'd',
                      ]
                   ]);
                   ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
                   <?= $form->field($model, 'cuisineIds')->widget(Select2::class, [
                      'data' => $model->cuisinesList,
                      'options' => ['placeholder' => 'Please select a cuisine', 'multiple' => true],
                      'pluginOptions' => [
                         'tokenSeparators' => [',', ' '],
                         'maximumInputLength' => 10,
                         'allowClear' => true,
                      ],
                   ])->label('Cuisines (for filter "Restaurants")'); ?>
					</div>
					<div class="col-md-6">
                   <?= $form->field($model, 'deliveryServiceIds')->checkboxList($model->deliveryServicesList) ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
                   <?php echo $form->field($model, 'restaurantIds')->widget(Select2::class, [
                      'options' => ['multiple' => true, 'placeholder' => 'Please select a restaurant'],
                      'data' => $model->restaurantsList,
                      'pluginOptions' => [
                         'allowClear' => true,
                         'minimumInputLength' => 2,
                         'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                         ],
                         'ajax' => [
                            'url' => '/admin/report/restaurant-list',
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {string:params.term,suburbs:$("#suburbids").val(),cuisines:$("#cuisineids").val()}; }')
                         ],
                      ],
                   ])->label('Restaurants (default: all restaurants)');
                   ?>
					</div>
					<div class="col-md-6" style="padding-top: 29px">
                   <?= Html::a('Reset', '/admin/report/general', ['class' => 'btn btn-default']) ?>
                   <?= Html::submitButton('Generate PDF', ['class' => 'btn btn-warning','id' => 'generate-pdf']) ?>
                   <?= Html::submitButton('Generate Report', ['class' => 'btn btn-primary','id' => 'generate-report']) ?>
					</div>
				</div>
             <?php ActiveForm::end() ?>
			</div>
		</div>
		<?= $this->render('render-report',['dataProvider' => $dataProvider, 'model' => $model]) ?>
	</div>
</div>
</div>
<?php
$js = <<<JS

$('#cuisineids,#suburbids').on('change',function() {
 	$('#restaurantids').val('');
 	$('#restaurantids').html('');
});

$('#generate-pdf').on('click',function(e) {
	e.preventDefault();
	form = document.getElementById('form-report');
	form.action = '/admin/report/pdf';
	form.setAttribute("target", "_blank");
	form.method = 'GET';
	form.submit();
});

$('#generate-report').on('click',function(e) {
	e.preventDefault();
	form = document.getElementById('form-report');
	form.action = '/admin/report/general';
	form.setAttribute("target", "");
	form.method = 'GET';
	form.submit();
});


JS;
$this->registerJs($js);
?>
