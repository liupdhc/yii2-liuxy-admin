<?php
/* @var $this yii\web\View */

use liuxy\admin\assets\plugins\jquery\JsTreeAsset;
use liuxy\admin\Module;
use liuxy\admin\widgets\ActiveForm;
use liuxy\admin\widgets\Modal;
use liuxy\admin\widgets\Tabs;
use liuxy\admin\widgets\Tools;
use liuxy\admin\widgets\Radio;
JsTreeAsset::register($this);
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box">
            <div class="portlet-body">
                <div class="tabbable-custom">
                    <?=Tabs::widget([
                        'items'=>[
                            [
                                'label'=>Module::t('perm.list.title'),
                                'active' => true,
                                'content'=>'<div id="perm-tree" class="tree-demo"></div>'
                            ],[
                                'label'=>Module::t('perm.seq.title'),
                                'headerOptions'=>[
                                    'onclick'=>'perm.get(this,"node_1");'
                                ],
                                'content'=>Tools::widget([
                                    'id'=>'tools',
                                    'items'=>[
                                        [
                                            'label'=>Module::t('goback'),
                                            'title'=>Module::t('goback'),
                                            'icon'=>'fa fa-backward',
                                            'options'=>['href'=>'javascript:void(0)']
                                        ]
                                    ],
                                    'content'=>'<div id="perm-table"></div>'
                                ])
                            ]
                        ]
                    ])?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php Modal::begin([
    'id'=>'perm-dialog'
]);?>
<div class="scroller" style="height:100%" data-always-visible="1" data-rail-visible1="1">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet-body form">

                <?php $form = ActiveForm::begin(['id' => 'perm-form']); ?>
                <?= $form->field('parent_id')->hiddenInput(['value'=>1]) ?>
                <?= $form->field('name')->textInput(['placeholder'=>Module::t('name')]) ?>
                <?= $form->field('link')->textInput(['placeholder'=>Module::t('link'),'value'=>'#']) ?>

                <div class="form-group">
                    <label class="control-label control-label"><?=Module::t('navigation')?></label>
                    <?php echo Radio::widget([
                        'name'=>'is_nav',
                        'items'=>[
                            \liuxy\admin\models\Permission::NAV_YES=>Module::t('yes'),
                            \liuxy\admin\models\Permission::NAV_NO=>Module::t('no')
                        ],
                        'values'=>[\liuxy\admin\models\Permission::NAV_NO]
                    ])?>
                </div>


                <?= $form->field('description')->textInput(['placeholder'=>Module::t('description')]) ?>
                <?= $form->field('icon')->textInput(['placeholder'=>Module::t('description'),
                    'value'=>'icon-list',
                    'icon'=>'ace-icon fa fa-external-link',
                    'icon-link'=>'http://fontawesome.io/icons/',
                    'typehead'=>true]) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php Modal::end();?>
<script type="text/javascript">
    _callbacks.push(function() {
        perm.init();
    });
</script>
