<?php

namespace GDForm\Database\Migrations;

use GDForm\Models\FieldType;

class CreateFieldTypesTable
{

    public static function run()
    {
        global $wpdb;

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "GDFormFieldTypes(
                Id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                Name text DEFAULT NULL,
                IsFree int(1) DEFAULT 1,
                PRIMARY KEY (Id)
            ) ENGINE=InnoDB"
        );

        self::insertDefaults();
        self::alterTable();
    }

    private static function insertDefaults()
    {
        global $wpdb;

        $rows = $wpdb->get_results('SELECT Id FROM '.$wpdb->prefix.'GDFormFieldTypes LIMIT 1');

        if(!empty($rows)){
            return;
        }

        $defaultTypes=array(
            array('name'=>'text','free'=>'1'),
            array('name'=>'email','free'=>'1'),
            array('name'=>'number','free'=>'1'),
            array('name'=>'textarea','free'=>'1'),
            array('name'=>'radio','free'=>'1'),
            array('name'=>'checkbox','free'=>'1'),
            array('name'=>'selectbox','free'=>'1'),
            array('name'=>'date','free'=>'1'),
            array('name'=>'recaptcha','free'=>'1'),
            array('name'=>'map','free'=>'2'),
            array('name'=>'captcha','free'=>'1'),
            array('name'=>'imageselect','free'=>'2'),
            array('name'=>'html','free'=>'1'),
            array('name'=>'password','free'=>'2'),
            array('name'=>'phone','free'=>'1'),
            array('name'=>'address','free'=>'2'),
            array('name'=>'upload','free'=>'1'),
            array('name'=>'submit','free'=>'1'),
            array('name'=>'donation','free'=>'2'),
        );

        foreach ($defaultTypes as $defaultType){
            $field_type = new FieldType();

            $field_type->setName( __( $defaultType['name'], GDFRM_TEXT_DOMAIN ) )
                       ->setIsFree($defaultType['free']);

            $field_type->save();
        }

    }

    private static function alterTable()
    {
        global $wpdb;



        $newTypes=array(
            array('name'=>'donation','free'=>'2'),
        );

        foreach ($newTypes as $newType){
            $typeExists = $wpdb->get_results('SELECT Id FROM '.$wpdb->prefix.'GDFormFieldTypes WHERE `Name`="'.$newType['name'].'" LIMIT 1');

            if(empty($typeExists)){
                $field_type = new FieldType();

                $field_type->setName( __( $newType['name'], GDFRM_TEXT_DOMAIN ) )
                    ->setIsFree($newType['free']);

                $field_type->save();
            }
        }

        $fieldstpyeproids=array(
            array('name'=>'map','free'=>'2'),
            array('name'=>'imageselect','free'=>'2'),
            array('name'=>'password','free'=>'2'),
            array('name'=>'address','free'=>'2'),
            array('name'=>'donation','free'=>'2'),
        );
        foreach ($fieldstpyeproids as $fieldstpyeproid) {
            $wpdb->update($wpdb->prefix . 'gdformfieldtypes', array( 'IsFree' => 2), array('Name' => $fieldstpyeproid['name']));
        }






    }

}