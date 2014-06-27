<?php

class UserOriDocs extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{user_original_docs}}';
    }

    public function primaryKey() {
        return 'oridoc_id';
    }

    public function relations() {
        return array(
            'docs' => array(self::HAS_ONE, 'Documents', array('oridoc_key' => 'oridoc_key')),
            'user' => array(self::HAS_ONE, 'User', array('user_key' => 'user_key'))
        );
    }

    public function scopes() {
        return array(
            'published' => array(
                'condition' => 'status=1',
            ),
            'recently' => array(
                'order' => 'created_at DESC',
                'limit' => 5,
            ),
            'orderbyname' => array(
                'order' => 'oridoc_name ASC'
            ),
            'orderbycreated' => array(
                'order' => 'created_at DESC'
            )
        );
    }

}
