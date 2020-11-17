<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "people".
 *
 * @property int $id
 * @property string|null $category_id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property int|null $gender
 * @property string $birthDate
 */
class People extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'people';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email', 'birthDate'], 'required'],
            [['gender'], 'integer'],
            [['birthDate'], 'safe'],
            [['category_id', 'firstname', 'lastname', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'gender' => 'Gender',
            'birthDate' => 'Birth Date',
        ];
    }
}
