<?php
/**
 * Author: liupeng
 * Date: 2015/7/11
 */

namespace liuxy\admin\components\helpers;

use Yii;
use yii\base\InvalidParamException;

/**
 * HTML工具类
 * Class Html
 *
 * @package liuxy\admin\components\helpers
 */
class Html extends \yii\helpers\Html {

    const FILEINPUT_IMG = <<< HTML
	<div class="progress">
        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
    </div>
    <span class="btn default btn-file">
        <span class="fileinput-new">更改</span>
        <span class="fileinput-exists">更改</span>
        <input type="file" name="{name}" class="fileupload" data-url="{uploadUrl}"/>
    </span>
    <span class="fileinput-filename"></span>&nbsp; <a href="#" class="close fileinput-exists" data-dismiss="fileinput"></a>
HTML;
    /**
     * @inheritDoc
     */
    /**
     * @inheritDoc
     */
    public static function getAttributeValue($model, $attribute) {
        if (!preg_match('/(^|.*\])([\w\.]+)(\[.*|$)/', $attribute, $matches)) {
            throw new InvalidParamException('Attribute name must contain word characters only.');
        }
        $attribute = $matches[2];
        $value = '';
        if ($model) {
            if (is_object($model) && property_exists($model, $attribute)) {
                $value = $model->$attribute;
            } else if(is_array($model) && isset($model[$attribute])) {
                $value = $model[$attribute];
            }
        }
        if ($matches[3] !== '') {
            foreach (explode('][', trim($matches[3], '[]')) as $id) {
                if ((is_array($value) || $value instanceof \ArrayAccess) && isset($value[$id])) {
                    $value = $value[$id];
                } else {
                    return null;
                }
            }
        }

        // https://github.com/yiisoft/yii2/issues/1457
        if (is_array($value)) {
            foreach ($value as $i => $v) {
                if ($v instanceof ActiveRecordInterface) {
                    $v = $v->getPrimaryKey(false);
                    $value[$i] = is_array($v) ? json_encode($v) : $v;
                }
            }
        } elseif ($value instanceof ActiveRecordInterface) {
            $value = $value->getPrimaryKey(false);

            return is_array($value) ? json_encode($value) : $value;
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public static function getInputName($model, $attribute) {
        $formName = $attribute;
        if (isset($attribute['formName'])) {
            $formName = $attribute['formName'];
        }
        if (!preg_match('/(^|.*\])([\w\.]+)(\[.*|$)/', $attribute, $matches)) {
            throw new InvalidParamException('Attribute name must contain word characters only.');
        }

        if (isset($attribute['formName'])) {
            return $formName . "[$attribute]";
        }
        return $formName;
    }


    /**
     * @inheritDoc
     */
    public static function activeLabel($model, $attribute, $options = []) {
        $for = array_key_exists('for', $options) ? $options['for'] : static::getInputId($model, $attribute);
        $label = isset($options['label']) ? $options['label'] : '';
        unset($options['label'], $options['for']);
        return static::label($label, $for, $options);
    }

    /**
     * @inheritDoc
     */
    public static function activeInput($type, $model, $attribute, $options = []) {
        $name = isset($options['name']) ? $options['name'] : static::getInputName($model, $attribute);
        $value = isset($options['value']) ? $options['value'] : static::getAttributeValue($model, $attribute);
        if (isset($options['placeholder'])) {
            $options['placeholder'] = $options['placeholder'];
        }
        if (!array_key_exists('id', $options)) {
            $options['id'] = static::getInputId($model, $attribute);
        }
        return static::input($type, $name, $value, $options);
    }

    /**
     * 生成可点击上传文件的元素内容
     * @param $name 元素名称
     * @param $url  上传地址
     * @return string
     */
    public static function activeUploadFile($name, $url) {
        return Html::tag('div', strtr(self::FILEINPUT_IMG,['{name}'=>$name,'{uploadUrl}'=>$url]),
            ['class'=>'fileinput fileinput-new','data-provides'=>'fileinput']);
    }

    /**
     * @inheritDoc
     */
    public static function error($model, $attribute, $options = []) {
        $tag = isset($options['tag']) ? $options['tag'] : 'div';
        unset($options['tag'], $options['encode']);
        return Html::tag($tag, '', $options);
    }

    /**
     * @inheritDoc
     */
    public static function activeHint($model, $attribute, $options = []) {
        $hint = isset($options['hint']) ? $options['hint'] : '';
        if (empty($hint)) {
            return '';
        }
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        unset($options['hint']);
        return static::tag($tag, $hint, $options);
    }

    /**
     * @inheritDoc
     */
    public static function beginForm($action = '', $method = 'post', $options = []) {
        if (!empty($action)) {
            $action = Url::to($action);
        }

        $hiddenInputs = [];

        $request = Yii::$app->getRequest();
        if ($request instanceof Request) {
            if (strcasecmp($method, 'get') && strcasecmp($method, 'post')) {
                // simulate PUT, DELETE, etc. via POST
                $hiddenInputs[] = static::hiddenInput($request->methodParam, $method);
                $method = 'post';
            }
            if ($request->enableCsrfValidation && !strcasecmp($method, 'post')) {
                $hiddenInputs[] = static::hiddenInput($request->csrfParam, $request->getCsrfToken());
            }
        }

        if (!strcasecmp($method, 'get') && ($pos = strpos($action, '?')) !== false) {
            // query parameters in the action are ignored for GET method
            // we use hidden fields to add them back
            foreach (explode('&', substr($action, $pos + 1)) as $pair) {
                if (($pos1 = strpos($pair, '=')) !== false) {
                    $hiddenInputs[] = static::hiddenInput(
                        urldecode(substr($pair, 0, $pos1)),
                        urldecode(substr($pair, $pos1 + 1))
                    );
                } else {
                    $hiddenInputs[] = static::hiddenInput(urldecode($pair), '');
                }
            }
            if (!empty($action)) {
                $action = substr($action, 0, $pos);
            }
        }
        if (!empty($action)) {
            $options['action'] = $action;
        }

        $options['method'] = $method;
        $form = static::beginTag('form', $options);
        if (!empty($hiddenInputs)) {
            $form .= "\n" . implode("\n", $hiddenInputs);
        }

        return $form;
    }


}