<?php

class SiteModule extends CWebModule {

    public function init() {
        
        parent::init();
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'site.models.*',
            'site.components.*',
        ));
        $this->setComponents(array(
            'errorHandler' => array(
                'errorAction' => 'site/home/error'),
            'theme'=>Yii::app()->params['admin-theme'],
        ));
    }

    public function beforeControllerAction($controller, $action) {
            return true;
    }

}
