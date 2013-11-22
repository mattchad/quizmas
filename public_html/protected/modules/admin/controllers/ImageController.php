<?php

class ImageController extends AdController
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('crop'),
				'roles'=>array('admin', 'editor'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionCrop($id, $folder, $image_type = 1)
	{
		switch($folder)
		{
			case 'news_single':
			{
				$Object = News::model()->findByPk($id);
				$return_route = array('news/update', 'id'=>$id);
				break;
			}
			case 'book':
			{
				$Object = Book::model()->findByPk($id);
				$return_route = array('book/update', 'id'=>$id);
				break;
			}
			case 'bookpack':
			{
				$Object = Bookpack::model()->findByPk($id);
				$return_route = array('bookpack/update', 'id'=>$id);
				break;
			}
			case 'publication':
			{
				$Object = Publication::model()->findByPk($id);
				$return_route = array('publication/update', 'id'=>$id);
				break;
			}
			case 'event':
			{
				$Object = Event::model()->findByPk($id);
				$return_route = $Object->updateRoute;
				break;
			}
		}
		
		if(isset($_POST['image']))
		{
            Yii::app()->functions->saveImageCrop($Object->id, $folder, $image_type, array('x'=>$_POST['image']['x'], 'y'=>$_POST['image']['y'], 'w'=>$_POST['image']['w'], 'h'=>$_POST['image']['h']), strtotime($Object->image));
			
			if($image_type == 2)
			{
				$Object->image_block_x = $_POST['image']['x'];
				$Object->image_block_y = $_POST['image']['y'];
				$Object->image_block_w = $_POST['image']['w'];
				$Object->image_block_h = $_POST['image']['h'];
			}
			else
			{
				$Object->image_thumbnail_x = $_POST['image']['x'];
				$Object->image_thumbnail_y = $_POST['image']['y'];
				$Object->image_thumbnail_w = $_POST['image']['w'];
				$Object->image_thumbnail_h = $_POST['image']['h'];
			}
			
			$Object->save(false);
			
			$this->redirect($return_route);
		}
		
		$this->render('crop', array(
			'Object'=>$Object,
			'return_route'=>$return_route,
			'image_type' => $image_type
		));
	}
}
