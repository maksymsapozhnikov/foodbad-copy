<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \common\models\Messages */

$this->title = 'Support Request #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Support Request', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>
<section class="content">
	<div class="request-view box box-primary">
		<div class="box-header">
			<div class="pull-right box-tools">
             <?= Html::a('Delete', ['delete-request', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-flat btn-sm',
                'data' => [
                   'confirm' => 'Are you sure you want to delete this item?',
                   'method' => 'post',
                ],
             ]) ?>
             <?= Html::a('<span class="fa fa-reply"></span> Close', ['support-requests'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
			</div>
		</div>
		<div class="box-body">
			<div class="">
				<?php if(!empty($model->fromUser)){
					$user = $model->fromUser;
					$imageSrc = ($user->image && is_file(Yii::getAlias('@storage' . '/users/' . $user->image))) ? Yii::$app->params['frontend_url'] . '/storage/users/' . $user->image : Yii::$app->params['backend_url'] . '/img/default.png';
				} ?>
				<?= Html::img($imageSrc,['style' => 'margin-left: 25px']) ?>
				<div class="user-info">
					<ul>
						<li><span class="glyphicon glyphicon-user"></span> <?= Html::encode($user->username) ?> <?= Html::encode($user->last_name) ?></li>
						<li><span class="glyphicon glyphicon-envelope"> </span> <?= $user->email ?></li>
						<li><span class="glyphicon glyphicon-phone-alt"> </span> <?= $user->phone ?></li>
					</ul>
				</div>
			</div>
			<div class="" style="padding: 25px">
             <?= Html::encode($model->body) ?>
			</div>
			<div class="box-images text-center">
             <?php if (!empty($model->requestImages)) {
                 foreach ($model->requestImages as $image) {
							echo Html::img(Yii::$app->params['backend_url'] . '/storage/support/' . $image->image);
                 }
             } ?>
			</div>
		</div>
	</div>
</section>
