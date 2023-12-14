<?php

namespace app\widgets;

use app\models\ForgotPasswordForm;
use app\models\LoginForm;
use app\models\SignUpForm;
use yii\base\Widget;

class AccountWidget extends Widget
{
    public $login;
    public $sign_up;
    public $forgot_password;

	public function init(){
        parent::init();

        $this->login = new LoginForm();
        $this->sign_up = new SignUpForm();
        $this->forgot_password = new ForgotPasswordForm();
    }

	public function run() {
		return $this->render('account/view', [
			'login' => $this->login,
			'sign_up' => $this->sign_up,
			'forgot_password' => $this->forgot_password,
		]);
	}
}
?>