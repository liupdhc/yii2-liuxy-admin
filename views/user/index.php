<?php
/* @var $this yii\web\View */

use liuxy\admin\Module;
use liuxy\admin\assets\plugins\jquery\SelectAsset;
use liuxy\admin\widgets\ActiveForm;
use liuxy\admin\widgets\Modal;
use liuxy\admin\widgets\GridTable;
use liuxy\admin\widgets\Checkbox;
use liuxy\admin\widgets\Radio;
use liuxy\admin\widgets\Select;

SelectAsset::register($this);
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box">
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <select name="user-status" data-value="<?=$data['opt']['status']?>" id="user-status" class="form-control input-sm">
                                        <option value="1"><?=Module::t('status.ok')?></option>
                                        <option value="0"><?=Module::t('status.no')?></option>
                                    </select>
                                </div>
                                <div class="col-md-3 btn-group">
                                    <button id="user-add" class="btn green-meadow">
                                        <?= Module::t( 'create') ?><i class="fa fa-plus"></i>
                                    </button>
                                </div>
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
                        'username'=>Module::t('user.username'),
                        'name'=>Module::t('user.name'),
                        'status'=>Module::t('status'),
                        'trd_identifier'=>Module::t('user.third.identifier'),
                        ''=>Module::t('operation')
                    ]]);?>
                <?php foreach($data['items'] as $item){
                    echo $jtable->line($item,['id'=>'tr-user-'.$item['id'],'class'=>'odd gradeX'],
                        [''=>'<div class="hidden-sm hidden-xs action-buttons">
                                    <a class="green" href="#" onclick="user.get('.$item['id'].');">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
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
    'id'=>'user-dialog'
]);?>
<div class="scroller" style="height:100%" data-always-visible="1" data-rail-visible1="1">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet-body form">
                <?php $form = ActiveForm::begin(['id' => 'user-form']); ?>
                <?= $form->field('id')->hiddenInput() ?>
                <?= $form->field('username')->textInput(['placeholder'=>Module::t('user.username')]) ?>
                <?= $form->field('password')->passwordInput(['placeholder'=>Module::t('user.password')]) ?>
                <?= $form->field('name')->textInput(['placeholder'=>Module::t('user.name')]) ?>
                <?= $form->field('trd_identifier')->textInput(['placeholder'=>Module::t('user.third.identifier')]) ?>

                <div class="form-group">
                    <label class="control-label control-label"><?=Module::t('role.list.title')?></label>
                    <?php echo Checkbox::widget([
                        'name'=>'role',
                        'items'=>$data['roles']
                    ])?>
                </div>
                <div class="form-group">
                    <label class="control-label control-label"><?=Module::t('status')?></label>
                    <?php echo Radio::widget([
                        'name'=>'status',
                        'items'=>$data['status'],
                        'values'=>[1]
                    ])?>
                </div>



                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php Modal::end();?>
    <script type="text/javascript">
        _callbacks.push(function() {
            user.init();
        });
    </script>
