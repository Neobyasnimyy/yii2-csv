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
     * @var $text
     */
    public $text;

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
                'tooBig' => "Файл «{file}» слишком большой. Размер не должен превышать 20 MB.",
            ],
        ];
    }

    /**
     * @return bool
     */
    public function getText()
    {
        if ($this->validate()) {
            $this->text = file_get_contents($this->uploadedFile->tempName);
            return true;
        } else {
            return false;
        }
    }
}