<?php
/* @var $this yii\web\View */

use liuxy\admin\widgets\ActiveForm;
use oppo\sns\modules\topic\Module;
?>

<div class="portlet-body form">
    <?php $form = ActiveForm::begin(['id' => 'role-form']); ?>
    <?= $form->field('id')->hiddenInput() ?>
    <?= $form->field('pids')->hiddenInput() ?>
    <?= $form->field('name')->textInput(['placeholder'=>Module::t('name')]) ?>
    <?= $form->field('description')->textInput(['placeholder'=>Module::t('description')]) ?>
    <div class="form-group">
        <div class="col-md-12">
            <div class="portlet green-meadow box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i><?= Module::t( 'role.perm.owner') ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="perm-tree" class="tree-demo" style="max-height: 200px;overflow-y:auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
