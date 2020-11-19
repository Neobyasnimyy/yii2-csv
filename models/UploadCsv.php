<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadCsv extends Model
{
    /**
     * @var UploadedFile
     */
    public $uploadedFile;

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uploadedFile' => Yii::t('models', "Uploaded File"),
        ];
    }
    /**
     * @var array
     */
    public $data = [];
    /**
     * @var array
     */
    public $new_categories = [];

    public function rules()
    {
        return [
            [
                ['uploadedFile'],
                'file',
                'skipOnEmpty' => false,
                'extensions' => 'csv',
                'checkExtensionByMimeType' => false,
                'maxSize' => 1024 * 1024 * 20,
                'tooBig' => Yii::t('models', "The file «{file}» is too large.
                 The size should not exceed 20 MB."),
            ],
        ];
    }

    /**
     * validate and transform the received data
     * @return bool
     */
    public function setData(): bool
    {
        if ($this->validate()) {
//            $this->data = str_getcsv(file_get_contents($this->uploadedFile->tempName));
            $categories = Categories::getCategories();
            if (($handle = fopen($this->uploadedFile->tempName, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($data[0] == 'category') {
                        continue;
                    }
                    $num = count($data);
                    $item = ($num > 6) ? array_slice($data, 0, 6) : $data;
                    $item[4] = ($item[4] == 'male') ? 1 : 2;
                    if (
                        !in_array($data[0], $categories)
                        and
                        !in_array($data[0], $this->new_categories)
                    ) {
                        $this->new_categories[] = $data[0];
                    }
                    $this->data[] = $item;
                }
                fclose($handle);
            }
            if (is_array($this->data) and !empty($this->data)) {
                return true;
            }
        }
        return false;
    }

}