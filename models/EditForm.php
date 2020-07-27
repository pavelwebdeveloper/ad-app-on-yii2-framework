<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\Session;


/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class EditForm extends Model
{
    public $title;
    public $description;
    public $author;
    public $datetime;
    public $siteuserId;

    public function create()
            {
     $announcement = new Announcement();
     $announcement->announcementTitle = $this->title;
     $announcement->announcementDescription = $this->description;
     $announcement->announcementAuthorName = $this->author;
     $announcement->announcementCreationDate = $this->datetime;
     $announcement->siteuserId = $this->siteuserId;
     return $announcement->save();
    }
    
     /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['title', 'description', 'author', 'datetime', 'siteuserId'], 'required'],
        ];
    }

    
    
    

    
}

