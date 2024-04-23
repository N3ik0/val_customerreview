<?php

if(!defined('_PS_VERSION_')){
     exit;
}


class Review extends ObjectModel{
     public $id_avis;
     public $id_product;
     public $note;
     public $avis;
     public $date_add;
     public $id_customer;
     public $name_customer;
     public $surname_customer;
     public $email_customer;

     public static $definition = array(
          'table' => 'review', 
          'primary' => 'id_review', 
          'fields' => array( 
               'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
               'note' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
               'comment' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
               'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
               'id_customer' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
               'name_customer' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
               'surname_customer' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
               'email_customer' => array('type' => self::TYPE_STRING, 'validate' => 'isEmail'),
          )
     );

     public static function getQuote($id_product){
          $context = Context::getContext();
      
          $quote = Db::getInstance()->executeS('SELECT d.*, pl.name FROM ' . _DB_PREFIX_ . 'review d LEFT JOIN ' . _DB_PREFIX_ . 
          'product_lang pl ON d.id_product = pl.id_product AND pl.id_lang = ' . (int)$context->language->id . ' WHERE d.id_product = ' . (int)$id_product);
      
          return $quote;
      }


     public static function getQuoteByCustomer($id_customer){


          $context = Context::getContext();

          $quote = Db::getInstance()->executeS('SELECT d.*, pl.name FROM ' . _DB_PREFIX_ . 'review d LEFT JOIN ' . _DB_PREFIX_ . 
          'product_lang pl ON d.id_product = pl.id_product AND pl.id_lang = ' . (int)$context->language->id . ' WHERE id_customer = ' . (int)$id_customer);
          
          return $quote;
     }

     public static function getQuoteByReview($id_review){
          $context = Context::getContext();

          $quoteReview = Db::getInstance()->executeS('SELECT d.*, pl.name FROM ' . _DB_PREFIX_ . 'review d LEFT JOIN ' . _DB_PREFIX_ . 
          'product_lang pl ON d.id_product = pl.id_product AND pl.id_lang = ' . (int)$context->language->id . ' WHERE id_review = ' . (int)$id_review);
          
          return $quoteReview;
     }


     public static function getStatus($id){
          $module = Module::getinstanceByName('val_val_customerreview');
          
          switch ($id){
               case '0' : 
                    return $module->l('En attente de traitement');
                    break;
          
               case '1' : 
                    return $module->l('En cours de traitement');
                    break;
          
               case '2' : 
                    return $module->l('Validé');
                    break;
               
               default:
                    return $module->l('En attente de traitement');
                    break;
          };
          }
}