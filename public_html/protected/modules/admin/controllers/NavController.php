<?php

class NavController extends AdController
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('update'),
				'roles'=>array('admin', 'editor'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Nav');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionUpdate($id)
	{
		$NavItem = new NavItem;
		
		//We're updating the order of the list of pages
		if(isset($_POST['nav_item']))
		{
			foreach($_POST['nav_item'] as $nav_item_id => $nav_item)
			{
				$NavItem = NavItem::model()->findByPk($nav_item_id);
				$NavItem->order_number = $nav_item['order'];
				$NavItem->save();
			}
			$this->redirect(array('nav/update','id'=>$id));
		}
		
		//We're adding a new nav item
		if(isset($_POST['NavItem']))
		{
			$NavItem->attributes=$_POST['NavItem'];
			$NavItem->nav_id = $id;
			$NavItem->page_choice = $_POST['NavItem']['page_choice'];
			$NavItem->listing_choice = $_POST['NavItem']['listing_choice'];
			
			if(strlen($NavItem->page_choice))
			{
				$NavItem->guid = $NavItem->page_choice;
			}
			else if(strlen($NavItem->listing_choice))
			{
				$NavItem->guid = $NavItem->listing_choice;
			}
			
			if($NavItem->validate())
			{
				$NavItem->save();
				$this->redirect(array('update','id'=>$id));
			}
		}
		
		//Build the possible options for the dynamic lists
		$available_listing_options = $listing_options = Yii::app()->params['listing_options'];
		
		$NavItems = NavItem::model()->findAll();
		foreach($NavItems as $NavItem)
		{
    		if(isset($available_listing_options[$NavItem->guid]))
    		{
        		unset($available_listing_options[$NavItem->guid]);
    		}
		}
		
		//Find all nav items ordered by 'order_number' attribute
		$NavItems = NavItem::model()->findAllByAttributes(array('nav_id'=>$id), array('order'=>'order_number ASC'));
		foreach($NavItems as $NavItem_single)
		{
			//If the guid is a number, we've found a page.
			if(is_numeric($NavItem_single->guid))
			{	
				$Page = Page::model()->findByPk($NavItem_single->guid);
				$NavItem_single->guid = CHtml::link($Page->title, array("page/" . $NavItem_single->guid));
			}
			else //The guid is text, so we're on a listing page. 
			{
				$NavItem_single->guid = CHtml::link($listing_options[$NavItem_single->guid], array($NavItem_single->guid));
			}
		}
		
		//Build the complete list of pages. 
		$Pages = CHtml::listData(Page::model()->orphans()->findAll(), "id", "title");

		$this->render('update', array(
			'NavItems' => $NavItems,
			'Nav' => $this->loadModel($id),
			'Pages' => $Pages,
			'listing_options' => $available_listing_options,
			'NavItem' => $NavItem,
		));
	}

	public function loadModel($id)
	{
		$model=Nav::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
