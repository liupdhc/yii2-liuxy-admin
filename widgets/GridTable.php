<?php
/**
 * Author: liupeng
 * Date: 2015/7/11
 */

namespace liuxy\admin\widgets;

use yii\db\ActiveRecord;
use liuxy\admin\components\helpers\Html;
use yii\widgets\LinkPager;


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
        $this->renderFooter();
        echo "\n" . Html::endTag('table');
        echo "\n" . Html::endTag('div');
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
            foreach($this->keys as $key) {
                $val = '';
                $tdContent = '';
                if ($this->checkbox) {
                    $tdContent .= Html::input('checkbox','','',['class'=>'checkboxes']);
                }
                if ($key === '') {
                    $tdContent = $tdOptions[''];
                    unset($tdOptions['']);
                } else {
                    if ($model instanceof ActiveRecord) {
                        $val = $model->getAttribute($key);
                    } else {
                        $val = $model[$key];
                    }
                    if (isset($tdOptions[$key])) {
                        $tmpOptions = $tdOptions[$key];
                        if (isset($tmpOptions['href'])) {
                            $tdContent .= Html::tag('a', $val, ['href'=>$tmpOptions['href']]);
                        } else {
                            $tdContent .= $val;
                        }
                    } else {
                        $tdContent .= $val;
                    }
                }
                $htmlContent.=Html::tag('td',$tdContent, isset($tdOptions[$key]) ? $tdOptions[$key] : []);
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
                    Html::input('checkbox','','',['class'=>'group-checkable','data-set'=>'#'.$this->id.'.checkboxes']),
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
            LinkPager::widget(['pagination'=>$this->pages]);
        }
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
