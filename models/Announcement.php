<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "announcement".
 *
 * @property int $announcementId
 * @property string $announcementTitle
 * @property string $announcementDescription
 * @property string $announcementAuthorName
 * @property string $announcementCreationDate
 * @property int $siteuserId
 */
class Announcement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'announcement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imageId', 'announcementTitle', 'announcementDescription', 'announcementAuthorName', 'siteuserId'], 'required'],
            [['imageId'], 'integer'],
            [['announcementDescription'], 'string'],
            [['announcementCreationDate'], 'safe'],
            [['siteuserId'], 'integer'],
            [['announcementTitle', 'announcementAuthorName'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'announcementId' => 'Announcement ID',
            'imageId' => 'Image ID',
            'announcementTitle' => 'Announcement Title',
            'announcementDescription' => 'Announcement Description',
            'announcementAuthorName' => 'Announcement Author Name',
            'announcementCreationDate' => 'Announcement Creation Date',
            'siteuserId' => 'Siteuser ID',
        ];
    }
}
