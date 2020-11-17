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
                'tooBig' => "Файл «{file}» слишком большой. Размер не должен превышать 20 MB.",
            ],
        ];
    }

    /**
     * валидируем и преобразуем полученные данные
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
                    $item[4] = ($item[4] == 'male') ? 1 : 0;
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