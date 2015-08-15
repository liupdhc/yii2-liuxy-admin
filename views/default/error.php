<?php

/**
 * Error view.
 *
 * @var yii\base\View $this View
 * @var string $name Error name
 * @var string $message Error message
 * @var Exception $exception Exception
 */

use yii\helpers\Html;

$this->title = $name; ?>
<div class="row">
	<div class="col-md-12 page-500">
		<div class="number">
			500
		</div>
		<div class="details">
			<div class="alert alert-danger">
				<?php
				if(YII_DEBUG) {
					echo $exception;
				} else {
					echo nl2br(Html::encode($msg));
				}
				?>
			</div>
			<p>&nbsp;</p>
		</div>
	</div>
</div>