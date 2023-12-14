<?php

namespace app\widgets;

use app\models\Contact;
use yii\base\Widget;

class ContactWidget extends Widget
{
    public $phone;
    public $email;
    public $instagram;

	public function init(){
        parent::init();

        $this->phone = Contact::findOne(['type' => 'Телефон']);
        $this->email = Contact::findOne(['type' => 'Електронна адреса']);
        $this->instagram = Contact::findOne(['type' => 'Instagram']);
    }

	public function run() {
		return $this->render('contact/view', [
			'phone' => $this->phone,
			'email' => $this->email,
			'instagram' => $this->instagram,
		]);
	}
}
?>