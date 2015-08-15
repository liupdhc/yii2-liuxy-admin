<?php
/**
 * FileName: DefaultController.php.
 * Author: liupeng
 * Date: 2015/7/01
 */
namespace liuxy\admin\controllers;

use liuxy\admin\components\Controller;
use liuxy\admin\models\AdminUser;
use liuxy\admin\Module;
use yii\helpers\Url;

/**
 * Backend default controller.
 */
class DefaultController extends Controller {

    /**
     * Backend main page.
     */
    public function actionIndex() {
    }

    /**
     * 登录
     */
    public function actionLogin() {
        $this->layout = false;

        $userName = $this->get('username', '');
        $password = $this->get('password', '');
        if ($this->request->getIsAjax()) {
            if (AdminUser::auth($userName, $password)) {
                $this->setResponseData('message', Module::t('login.success'));
                $this->setResponseData('data', Url::toRoute(\Yii::$app->defaultRoute));
            } else {
                $this->setError(Module::t('login.failed'), 401);
                $this->setResponseData('data', Url::toRoute('login'));
            }
        } else if (AdminUser::isLoged()) {
            $this->goHome();
        }
    }

    /**
     * 注销
     */
    public function actionLogout() {
        AdminUser::setLogout();
        if ($this->request->getIsAjax()) {
            $this->setResponseData('data', Url::toRoute('login'));
        } else {
            $this->redirect(Url::toRoute('login'));
        }
    }

    /**
     * 无权限操作
     */
    public function actionDeny() {
        if ($this->request->getIsAjax()) {
            $this->setError(Module::t('deny'), 403);
        }
    }
}
