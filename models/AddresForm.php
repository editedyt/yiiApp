<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AddresForm extends Model
{
    public $party_abbreviation;
    public $party_score;
    public $date_entered;
    public $user_ip_address;
    public $entered_by_user;

    /**
     * @return array and the validation rules.
     */
    public function rules()
    {
        return [
            [['party_abbreviation', 'party_score', 'entered_by_user', 'user_ip_address', 'date_entered'], 'required'],
        ];
    }
}