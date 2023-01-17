<?php

// This is the anouncement controller

namespace app\controllers;

use Yii;
use yii\base\Model;
use yii\web\Session;


use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\EditForm;
use yii\data\Pagination;
use app\models\Announcement;
use app\models\Image;
use app\models\UploadForm;
use yii\web\UploadedFile;



class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    
 
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays startpage.
     *
     * @return string
     */
    public function actionIndex()
    {
     
     // start a session
     $session = Yii::$app->session;
     $username = "name";
     
      $query = Announcement::find();
      
       $images = Image::find()
           ->indexBy('id')
           ->all();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $announcements = $query->orderBy('announcementTitle')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        
              
     
      if (!Yii::$app->user->isGuest) {
            return $this->render('index', [
            'announcements' => $announcements,
            'pagination' => $pagination,
            'loggedIn' => $session->get('loggedIn'),
            'userId' => $session->get('userId'),
            'username'=>$session->get('username'),
                'images'=> $images,
        ]);
        } else {
            return $this->render('index', [
            'announcements' => $announcements,
            'pagination' => $pagination,
            'loggedIn' => $session->get('loggedIn'),
            'userId' => $session->get('userId'),
            'username'=>$session->get('username'),
                'images'=> $images,
        ]);
        }
        
    }
    
    
      public function actionAds()
    {
     
     // start a session
     $session = Yii::$app->session;
     $username = "name";
     
      $query = Announcement::find();
      
       $images = Image::find()
           ->indexBy('id')
           ->all();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $announcements = $query->orderBy('announcementTitle')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        
              
     
      if (!Yii::$app->user->isGuest) {
            return $this->render('ads', [
            'announcements' => $announcements,
            'pagination' => $pagination,
            'loggedIn' => $session->get('loggedIn'),
            'userId' => $session->get('userId'),
            'username'=>$session->get('username'),
                'images'=> $images,
        ]);
        } else {
            return $this->render('ads', [
            'announcements' => $announcements,
            'pagination' => $pagination,
            'loggedIn' => $session->get('loggedIn'),
            'userId' => $session->get('userId'),
            'username'=>$session->get('username'),
                'images'=> $images,
        ]);
        }
        
    }
    
         
    public function actionLogin()
    {
     
     // start a session
     $session = Yii::$app->session;
     $username = "name";
        
              
     $model = new LoginForm();
      if (!Yii::$app->user->isGuest) {
            return $this->render('login', [
            'model' => $model,
            'announcements' => $announcements,
            'pagination' => $pagination,
            'loggedIn' => $session->get('loggedIn'),
            'userId' => $session->get('userId'),
            'username'=>$session->get('username'),
                'images'=> $images,
        ]);
        }

        
        if ($model->load(Yii::$app->request->post()) && $model->getin()) {
             $session->set('loggedIn', true);
             
             $userId = (new \yii\db\Query())
                ->select(['siteuserId'])
                ->from('siteuser')
                ->where(['username' => $model->username])
                ->all();
             
             $session->set('userId', $userId);
             $session->set('username', $model->username);
             
            return $this->render('login', [
             'loggedIn' => $session->get('loggedIn'),
             'userId' => $session->get('userId'),
             'username'=>$session->get('username'),
                'images'=> $images,
        ]);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
            'loggedIn' => $session->get('loggedIn'),
            'userId' => $session->get('userId'),
            'username'=>$session->get('username'),
        ]);      
        
        return $this->render('login');
    }
    
    /**
     * Upload action.
     *
     * @return Response|string
     */
    
    public function actionUpload()
    {
        $model = new UploadForm();
        
        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // file is uploaded successfully
             $success_message = "File is uploaded successfully";
                return $this->render('upload', [
                    'model' => $model,
                    'success_message' => $success_message,
                        ]);
            }
        }
        
              

        return $this->render('upload', [
            'model' => $model,
             'success_message' => "",
            
            ]);
    }
    
    /**
     * Delete action.
     *
     * @return Response|string
     */
    public function actionDelete($announcementId)
    {
     $session = Yii::$app->session;
     
     // Test code
     // var_dump($announcementId);
     
        $query = Announcement::find();
        
         $images = Image::find()
           ->indexBy('id')
           ->all();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $announcements = $query->orderBy('announcementTitle')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        
        $announcement = Announcement::findOne((int)$announcementId)->delete();
        
        if($announcement){
         $session->setFlash('message', 'Ad Deleted Successfully');
         return $this->redirect(['index',
             'loggedIn' => $session->get('loggedIn'),
             'userId' => $session->get('userId'),
             'username'=>$session->get('username'),
             'announcements' => $announcements,
             'pagination' => $pagination,
             'images'=> $images,
         ]);
        }      
    }
    
    /**
     * Create ad action.
     *
     * @return Response
     */
    public function actionCreate()
    { 
        $session = Yii::$app->session;
       
        
        $model = new EditForm();
        
        $images = Image::find()
           ->indexBy('id')
           ->all();
        
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
         
         // setting flash-message
         $session->setFlash('message', 'You have successfully added an ad.');
         
         $announcementId = Announcement::find()
             ->max('announcementId');
         
         $createdAnnouncement = Announcement::find()
             ->where(['announcementId' => $announcementId])
             ->one();
         
         $image = Image::findOne($createdAnnouncement['imageId']);
                 
          return $this->render('showad', [
              'message' => $session->getFlash('message'),
              'announcement' => $createdAnnouncement,
              'loggedIn' => $session->get('loggedIn'),
              'userId' => $session->get('userId'),
              'username'=>$session->get('username'),
              'image'=>$image['imagePath'],
        ]);
         
        }
        
        return $this->render('create', [
             'model' => $model,
             'loggedIn' => $session->get('loggedIn'),
             'userId' => $session->get('userId'),
             'username'=>$session->get('username'),
            'images' => $images,
        ]);
    }
    
    
    /**
     * Edit action.
     *
     * @return Response|string
     */
    
    public function actionEdit($announcementId)
    {
        $session = Yii::$app->session;
                
        $model = new EditForm();
        
        $images = Image::find()
           ->indexBy('id')
           ->all();
        
        $announcement = Announcement::findOne((int)$announcementId);
        
        if($post = $model->load(Yii::$app->request->post())){
         
         $session->setFlash('message', 'You have successfully updated the ad.');
         
         $announcement->imageId = $model->imageId;
         $announcement->announcementTitle = $model->title;
         $announcement->announcementDescription = $model->description;
         $announcement->save();
         
         $image = Image::findOne($announcement['imageId']);
         
         return $this->render('showad', [
             'message' => $session->getFlash('message'),
             'loggedIn' => $session->get('loggedIn'),
             'userId' => $session->get('userId'),
             'username'=>$session->get('username'),
             'announcement' => $announcement,
             'image'=>$image['imagePath'],
         ]);
        }
        
         if($announcement){
         return $this->render('edit', [
              'message' => $session->getFlash('message'),
              'post' => $post,        
              'model' => $model,
              'loggedIn' => $session->get('loggedIn'),
              'userId' => $session->get('userId'),
              'username'=>$session->get('username'),
              'announcement' => $announcement,
             'images' => $images,             
         ]);
        }       
    }
     
    /**
     * Show ad action.
     *
     * @return Response|string
     */
    
    public function actionShow($announcementId)
    {
        $session = Yii::$app->session;
        $session->setFlash('message', ' ');
        
        $announcement = Announcement::findOne((int)$announcementId);
        
        $image = Image::findOne($announcement['imageId']);
        
        return $this->render('showad', [
              'message' => $session->getFlash('message'),
              'announcement' => $announcement,
              'loggedIn' => $session->get('loggedIn'),
              'userId' => $session->get('userId'),
              'username'=>$session->get('username'),
            'image'=> $image['imagePath'],
        ]);     
    }
     
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        
        $session['loggedIn'] = false;

        return $this->goHome();
    }

}
