<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Polls extends ActiveRecord
{
    public $party_abbreviation;
    public $party_score;
    public $date_entered;
    public $user_ip_address;
    public $entered_by_user;

    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['party_abbreviation', 'party_score', 'entered_by_user', 'date_entered', 'user_ip_address'], 'required'],
            // email has to be a valid email address
            // ['email', 'email'],
            // verifyCode needs to be entered correctly
            // ['verifyCode', 'captcha'],
        ];
    }
}