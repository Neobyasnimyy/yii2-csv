<?php

namespace app\models;

use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Self_;
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

    /**
     * @param array $people
     * @return int
     * @throws \yii\db\Exception
     */
    public static function saveManyPeople(array $people)
    {
        $people = self::addCategoryId($people);
        return Yii::$app->db->createCommand()->batchInsert(self::tableName(),
            ['category_id', 'firstname', 'lastname', 'email', 'gender', 'birthDate'],
            array_slice($people, 0, 10)
        )->execute();
    }

    /**
     * изменяем поле category на $category_id
     *
     * @param array $people
     * @return array
     */
    public static function addCategoryId(array $people)
    {
        $categories = Categories::getCategories();
        foreach ($people as &$item){
            $item[0] = array_search($item[0],$categories);
        }
        return $people;
    }

}
