<?php

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

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $announcements = $query->orderBy('announcementTitle')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        
              
     $model = new LoginForm();
      if (!Yii::$app->user->isGuest) {
            return $this->render('index', [
            'model' => $model,
            'announcements' => $announcements,
            'pagination' => $pagination,
            'loggedIn' => $session->get('loggedIn'),
            'userId' => $session->get('userId'),
            'username'=>$session->get('username'),
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
             
            return $this->render('index', [
             'announcements' => $announcements,
             'pagination' => $pagination,
             'loggedIn' => $session->get('loggedIn'),
             'userId' => $session->get('userId'),
             'username'=>$session->get('username'),
        ]);
        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
            'announcements' => $announcements,
            'pagination' => $pagination,
            'loggedIn' => $session->get('loggedIn'),
            'userId' => $session->get('userId'),
            'username'=>$session->get('username'),
        ]);      
        
        return $this->render('index');
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
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
         
         // setting flash-message
         $session->setFlash('message', 'You have successfully added an ad.');
         
         $announcementId = Announcement::find()
             ->max('announcementId');
         
         $createdAnnouncement = Announcement::find()
             ->where(['announcementId' => $announcementId])
             ->one();
                 
          return $this->render('showad', [
              'message' => $session->getFlash('message'),
              'announcement' => $createdAnnouncement,
              'loggedIn' => $session->get('loggedIn'),
              'userId' => $session->get('userId'),
              'username'=>$session->get('username'),
        ]);
         
        }
        
        return $this->render('create', [
             'model' => $model,
             'loggedIn' => $session->get('loggedIn'),
             'userId' => $session->get('userId'),
             'username'=>$session->get('username'),
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
        
        $announcement = Announcement::findOne((int)$announcementId);
        
        if($post = $model->load(Yii::$app->request->post())){
         
         $session->setFlash('message', 'You have successfully updated the ad.');
         
         $announcement->announcementTitle = $model->title;
         $announcement->announcementDescription = $model->description;
         $announcement->save();
         
         return $this->render('showad', [
             'message' => $session->getFlash('message'),
             'loggedIn' => $session->get('loggedIn'),
             'userId' => $session->get('userId'),
             'username'=>$session->get('username'),
             'announcement' => $announcement,
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
        
        return $this->render('showad', [
              'message' => $session->getFlash('message'),
              'announcement' => $announcement,
              'loggedIn' => $session->get('loggedIn'),
              'userId' => $session->get('userId'),
              'username'=>$session->get('username'),
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
