<?php
/**
 * Author: liupeng
 * Date: 2015/7/11
 */

namespace liuxy\admin\widgets;

use yii\db\ActiveRecord;
use liuxy\admin\components\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use liuxy\admin\Module;


/**
 * 基于datatable插件的表格
 * 用法：
 * ~~~php
 * $jtable = GridTable::begin([
 *     'header' => [
 *     'name'=>'name',
 *     'description'=>'description',
 *     'status'=>'status',
 *     ''=>'operation'
 *     ],
 *     'toggleButton' => ['label' => 'click me'],
 * ]);
 *
 * foreach($data['items'] as $item){
 * $jtable->line($item,$options,$tdOptions);
 *
 * }
 * GridTable::end();
 * ~~~
 *
 * 注意：对于操作列，header配置中的key必须为空字符串，$tdOptions也进支持HTML内容设置，如下所示：
 *
 * $jtable->line($item,['id'=>$item['id'],'class'=>'odd gradeX'],
 * [''=>'<div class="hidden-sm hidden-xs action-buttons">
 * <a class="green" href="#" onclick="role.get('.$item['id'].');">
 * <i class="ace-icon fa fa-pencil bigger-130"></i>
 * </a>
 *
 * <a class="red" href="#" onclick="role.delete('.$item['id'].');">
 * <i class="ace-icon fa fa-trash-o bigger-130"></i>
 * </a>
 * </div>']
 * );
 *
 * Class GridTable
 *
 * @package liuxy\themes\admin\widgets
 */
class GridTable extends Widget {

    /**
     * 扩展应用于table的class
     * @var array|string
     */
    public $class = null;

    /**
     * @var array
     */
    public $header = null;

    private $keys = null;

    /**
     * @var \yii\data\Pagination
     */
    public $pages = null;

    /**
     * @var bool 是否增加checkbox选中列
     */
    public $checkbox = false;

    const PAGES = <<< HTML
	<div class="row">
	<div class="col-md-5 col-sm-12"><div class="dataTables_info" id="{id}_info" role="status" aria-live="polite">{content}</div></div>
	<div class="col-md-7 col-sm-12">
			<div class="dataTables_paginate paging_bootstrap_full_number" id="{id}_paginate">
			{pages}
			</div>
	</div>
	</div>
HTML;



    /**
     * (non-PHPdoc)
     * @see \yii\bootstrap\Widget::init()
     */
    public function init() {
        parent::init();
        if (!isset ($this->options ['id'])) {
            $this->options ['id'] = $this->getId();
        }
        $this->initOptions();
        echo Html::beginTag('div', ['class'=>'table-scrollable']). "\n";
        echo Html::beginTag('table', $this->options). "\n";
        echo $this->renderHeader() . "\n";
        echo Html::beginTag('tbody'). "\n";
    }
    /**
     * (non-PHPdoc)
     * @see \yii\base\Widget::run()
     */
    public function run() {
        echo "\n" . Html::endTag('tbody');
        echo "\n" . Html::endTag('table');
        echo "\n" . Html::endTag('div');
        echo "\n" . $this->renderFooter();
    }

    /**
     * 渲染每一行数据
     * @param       $model  行数据
     * @param array $options   tr属性设置
     * @param array $tdOptions   特定td属性设置，以列名为key，如['name'=>[]
     */
    public function line($model, $options = [], $tdOptions = []) {
        if ($this->header) {
            $htmlContent = '';
            if ($this->checkbox) {
                $chxValue = '';
                if (isset($this->checkbox['value']) ) {
                    if ($model instanceof ActiveRecord) {
                        $chxValue = $model->getAttribute($this->checkbox['value']);
                    } else {
                        $chxValue = $model[$this->checkbox['value']];
                    }
                }
                $htmlContent .= Html::tag('td',Html::input('checkbox',isset($this->checkbox['name']) ? $this->checkbox['name'] : '', $chxValue, ['class'=>'checkboxes']), []);
            }
            foreach($this->keys as $key) {
                $val = '';
                $tdContent = '';
                if ($key === '') {
                    $tdContent = $tdOptions[''];
                    unset($tdOptions['']);
                } else {
                    if ($model instanceof ActiveRecord) {
                        $val = $model->hasAttribute($key) ? $model->getAttribute($key) : '';
                    } else {
                        $val = isset($model[$key]) ? $model[$key] : '';
                    }
                    if (isset($tdOptions[$key])) {
                        $tmpOptions = $tdOptions[$key];
                        if (isset($tmpOptions['href'])) {
                            //支持超链接
                            $tdContent .= Html::tag('a', $val, ['href'=>$tmpOptions['href']]);
                        } elseif (isset($tmpOptions['img'])) {
                            //支持图片
                            if (isset($tmpOptions['img']['editable'])) {
                                $tdContent = Html::activeUploadFile($key, $tmpOptions['img']['data-url']);
                            }
                            $tdContent .= Html::tag('a', Html::tag('img', '', ArrayHelper::merge(['src'=>$val],$tmpOptions['img'])), ['href'=>$val]);
                            unset($tdOptions[$key]['img']);
                        } else {
                            $tdContent .= $val;
                        }
                    } else {
                        $tdContent .= $val;
                    }
                }
                $htmlContent.=Html::tag('td',$tdContent, isset($tdOptions[$key]) && is_array($tdOptions[$key])? $tdOptions[$key] : []);
                unset($tdContent);
            }
            return Html::tag('tr',$htmlContent,$options);
        }
        return '';
    }

    /**
     * 渲染表头
     * @return string
     */
    protected function renderHeader() {
        if ($this->header) {
            $this->keys = array_keys($this->header);
            $renderContent = '';
            if ($this->checkbox) {
                $renderContent .= Html::tag('th',
                    Html::input('checkbox','','',['class'=>'group-checkable','data-set'=>'#'.$this->id.' .checkboxes']),
                    ['class'=>'table-checkbox']);
            }
            foreach($this->header as $key=>$val) {
                $renderContent .= Html::tag('th',$val);
            }
            return Html::tag('thead',Html::tag('tr',$renderContent));
        }
        return '';
    }

    /**
     * 渲染分页
     * @return string
     */
    protected function renderFooter() {
        if ($this->pages) {
            return self::renderPages($this->pages);
        }
    }

    /**
     * 生成分页HTML内容
     * @param $pages
     * @return string
     * @throws \Exception
     */
    public static function renderPages($pages) {
        $end = ($pages->getOffset()+$pages->getLimit()) >$pages->totalCount ?
            $pages->totalCount:$pages->getOffset()+$pages->getLimit();

        if ($pages->totalCount > 0) {
            $content = strtr(Module::t('gridtable.pages.title'),[
                '{total}'=>$pages->totalCount,
                '{start}'=>$pages->getOffset()+1,
                '{end}'=>$end
            ]);
        } else {
            $content = Module::t('gridtable.norecords');
        }
        return strtr(self::PAGES,[
            '{pages}'=>LinkPager::widget(['pagination'=>$pages]),
            '{content}'=>$content
        ]);
    }

    /**
     * 渲染操作列
     */
    protected function renderOperation() {

    }

    /**
     * 设置默认配置项
     */
    protected function initOptions() {
        $this->options = array_merge([
            'class' => 'table table-striped table-bordered table-hover dataTable'
        ], $this->options);
        if (!$this->pages) {
            Html::addCssClass($this->options, 'no-footer');
        }
        if ($this->class) {
            if (is_string($this->class)) {
                $this->class = explode(' ',$this->class);
            }
            foreach($this->class as $cl) {
                Html::addCssClass($this->options, $cl);
            }
        }
    }
}
