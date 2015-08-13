<?php
/* @var $this yii\web\View */

use liuxy\admin\assets\plugins\jquery\JsTreeAsset;
use liuxy\admin\Module;
use liuxy\admin\widgets\ActiveForm;
use liuxy\admin\widgets\Modal;
use liuxy\admin\widgets\GridTable;
JsTreeAsset::register($this);
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box">
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <button id="role-add" class="btn green-meadow">
                                    <?= Module::t( 'create') ?><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                /**
                 * @var $jtable \liuxy\admin\widgets\GridTable
                 */
                $jtable= GridTable::begin( [
                    'header' => [
                        'name'=>Module::t('name'),
                        'description'=>Module::t('description'),
                        'status'=>Module::t('status'),
                        ''=>Module::t('operation')
                    ]]);?>
                <?php foreach($data['items'] as $item){
                    echo $jtable->line($item,['id'=>'tr-role-'.$item['id'],'class'=>'odd gradeX'],
                        [''=>'<div class="hidden-sm hidden-xs action-buttons">
                                    <a class="green" href="#" onclick="role.get('.$item['id'].');">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>

                                    <a class="red" href="#" onclick="role.delete('.$item['id'].');">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </a>
                                </div>']
                        );
                } ?>
                <?php GridTable::end();?>
            </div>
        </div>
    </div>
</div>
<?php Modal::begin([
    'id'=>'role-dialog'
]);?>
<div class="scroller" style="height:100%" data-always-visible="1" data-rail-visible1="1">
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>
</div>
<?php Modal::end();?>
    <script type="text/javascript">
        _callbacks.push(function() {
            role.init();
        });
    </script>
