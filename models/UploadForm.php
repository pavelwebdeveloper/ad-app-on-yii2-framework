<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    
    
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('../images/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
             $image = new Image();
     $image->imagePath = '../images/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
     
     //$product->userId = $this->userId;
     //var_dump($product);
     //exit;
     //var_dump($product)."<br>";
        // exit;
     $image->save();
            return true;
        } else {
            return false;
        }
    }
}


