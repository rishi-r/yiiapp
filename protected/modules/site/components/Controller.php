<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();
        
        public $theme_path;
        public $links = array();
        
        public function init()
        {
            $this->links =  array(
                                "<i class='fa fa-tachometer'></i> Dashboard" => Yii::app()->createUrl("admin")
                            );
            Yii::app()->setTheme(Yii::app()->params['admin-theme']) ;
            Yii::app()->user->setId(4);
            $this->theme_path = Yii::app()->theme->baseUrl."/";
        }
        
        function bCrumbs($links2 = array())
        {
            $this->breadcrumbs = array_merge($this->links,$links2);
        }
}