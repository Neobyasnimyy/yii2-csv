<?php

namespace app\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return array
     */
    public static function getCategories(): array
    {
        $categories = [];
        $data = self::find()->asArray()->all();
        foreach ($data as $key => $value) {
            $categories[$value['id']] = $value['name'];
        }
        return $categories;
    }

    /**
     * @param array $arr
     * @return bool|int
     */
    public static function saveManyCategories(array $arr)
    {
        $query = [];
        foreach ($arr as $item) {
            $query[][] = $item;
        }
        try {
            return Yii::$app->db->createCommand()->batchInsert(self::tableName(),
                ['name'],
                $query
            )->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}
