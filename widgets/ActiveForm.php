<?php
/**
 * Author: liupeng
 * Date: 2015/7/11
 */

namespace liuxy\admin\widgets;

use Yii;
use liuxy\admin\components\helpers\Html;
use yii\base\InvalidCallException;
use liuxy\admin\widgets\ActiveField;
use yii\helpers\ArrayHelper;

/**
 * 表单
 * Class ActiveForm
 *
 * @package liuxy\themes\admin\widgets
 */
class ActiveForm extends Widget {
    /**
     * @var string  定义表单提交的url，将使用\yii\helpers\Url::to()进行转换
     */
    public $action = '';
    /**
     * @var string  post或get请求
     *  $form = ActiveForm::begin([
     *     'method' => 'get',
     *     'action' => ['[module/]controller/action'],
     * ]);
     *
     */
    public $method = 'post';
    /**
     * @var array   form标签的属性列表，如enctype="multipart/form-data"
     */
    public $options = [];

    /**
     * 用于生成表单元素的类
     *
     * @var string
     * @see $fieldConfig
     */
    public $fieldClass = 'liuxy\admin\widgets\ActiveField';
    /**
     * 表单元素的默认配置
     *
     * @var array
     * @see $fieldClass
     */
    public $fieldConfig = [];
    /**
     * 表单关联的数据对象或数组
     * @var object or array
     */
    public $model = false;

    /**
     * 初始化widget，设置form标签头部
     *
     * @see \yii\base\Object::init()
     */
    public function init() {
        if (!isset ($this->options ['id'])) {
            $this->options ['id'] = $this->getId();
        }
        echo Html::beginForm($this->action, $this->method, $this->options);
        echo $this->field('_csrf')->hiddenInput(['value'=>Yii::$app->request->getCsrfToken()]);
        parent::init();
    }

    /**
     * (non-PHPdoc)
     *
     * @see \yii\base\Widget::run()
     */
    public function run() {
        if (!empty($this->_fields)) {
            throw new InvalidCallException('Each beginField() should have a matching endField() call.');
        }
        echo Html::endForm();
    }

    /**
     * 设置表单域名
     *
     * @param       $attribute
     * @param array $options
     * @return \liuxy\admin\widgets\ActiveField
     */
    public function field($attribute, $options = []) {
        $config = $this->fieldConfig;
        if (!isset($config['class'])) {
            $config['class'] = $this->fieldClass;
        }

        return Yii::createObject(ArrayHelper::merge($config, $options, [
            'model' => $this->model,
            'attribute' => $attribute,
            'form' => $this,
        ]));
    }

    /**
     * @param       $model
     * @param       $attribute
     * @param array $options
     * @return mixed
     */
    public function beginField($model, $attribute, $options = []) {
        $field = $this->field($model, $attribute, $options);
        $this->_fields[] = $field;
        return $field->begin();
    }

    /**
     * @return string
     */
    public function endField() {
        $field = array_pop($this->_fields);
        if ($field instanceof ActiveField) {
            return $field->end();
        } else {
            throw new InvalidCallException('Mismatching endField() call.');
        }
    }

    public function formName() {
        return '';
    }
}