<?php 

if(!defined('_PS_VERSION_')){
     exit;
}

require_once _PS_MODULE_DIR_.'val_customerreview/classes/Review.php';


class Val_customerreview extends Module {

     public function __construct(){

          $this->name = 'val_customerreview'; 
          $this->tab = 'front_office_features'; 
          $this->version = '1.0.0'; 
          $this->author = 'Valentin';
          $this->need_instance = 0; 
          $this->bootstrap = true; 

          parent::__construct(); 

          $this->displayName = $this->l('Review module'); 
          $this->description = $this->l('Allow customers to give review'); 
     }

     public function install(){
          if(!parent::install() ||
               !$this->registerHook('displayFooterProduct') ||
               !$this->registerHook('actionFrontControllerSetMedia') ||
               !$this->registerHook('displayCustomerAccount') ||
               !$this->registerHook('displayProductAdditionalInfo') ||
               !$this->registerHook('actionFrontControllerSetMedia') ||
               !$this->createTable()
          ){
               return false;
          }
          return true;
     }

     private function createTable(){
          $sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'review` (
               `id_review` int(11) NOT NULL AUTO_INCREMENT,
               `id_product` int(11) NOT NULL,
               `id_customer` int(11) NOT NULL,
               `note` int(11) NOT NULL,
               `comment` text NOT NULL,
               `date_add` datetime NOT NULL,
               `name_customer` varchar(255) NOT NULL,
               `surname_customer` varchar(255) NOT NULL,
               `email_customer` varchar(255) NOT NULL,
               PRIMARY KEY (`id_review`)
          ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

          return Db::getInstance()->execute($sql);
     }


     public function uninstall(){

          Configuration::deleteByName('REVIEW_TITLE');
          Configuration::deleteByName('REVIEW_DESCRIPTION');
          Configuration::deleteByName('CONNECTION_REQUIRED');
          Configuration::deleteByName('CAN_REVIEW_ARTICLE');

          return parent::uninstall();
     }

     public function hookActionFrontControllerSetMedia(){
          
          $this->context->controller->registerStylesheet(
               'module-val_custommerreview-style', //identifiant
               'modules/'.$this->name.'/assets/css/front.css' // chemin
          );

     }

     public function hookDisplayCustomerAccount(){
          $result = Review::getQuoteByCustomer($this->context->customer->id);

          if($result){
               return $this->display(__FILE__, 'customeraccount.tpl');
          }
     }

     public function hookDisplayProductAdditionalInfo(){

          $id_product = Tools::getValue('id_product');
          $params = ( array(
                              'id_product' => $id_product
                         ) );

                         $title = Configuration::get('REVIEW_TITLE');
                         $description = Configuration::get('REVIEW_DESCRIPTION');
               
                         $this->context->smarty->assign(array(
                              'titlereview' => $title,
                              'descriptionreview' => $description
                              
                         ));
          
          $formReview = $this->context->link->getModuleLink('val_customerreview', 'FormReview', $params);
          $this->context->smarty->assign(array(
               'formReview' => $formReview
          ));
          
          $reviews = Review::getQuote($id_product);
          
          $product = new Product((int)$id_product, false, $this->context->language->id);
          
          $this->context->smarty->assign(array(
               'reviews' => $reviews,
               'product' => $product,
           ));
          
          
          return $this->display(__FILE__, 'review.tpl');
     }

      public function hookDisplayFooterProduct(){
          $title = Configuration::get('REVIEW_TITLE');
          $description = Configuration::get('REVIEW_DESCRIPTION');

          $this->context->smarty->assign(array(
               'titlereview' => $title,
               'descriptionreview' => $description
               
          ));

          return $this->display(__FILE__, 'review.tpl');
     }


     public function getContent(){

          $output = null;

          if(Tools::isSubmit('submit'.$this->name)){

               $title = Tools::getValue('COMMENT');
               $description = Tools::getValue('REVIEW_DESCRIPTION');

               if(!$title){
                    $output .= $this->displayError($this->l('The title field is required'));
               } else {
                    Configuration::updateValue('REVIEW_TITLE', $title); 
                    $output .= $this->displayConfirmation($this->l('Title updated')); 
               }

               if(Validate::isCleanHtml($description)){
                    Configuration::updateValue('REVIEW_DESCRIPTION', $description, true);
                    $output .= $this->displayConfirmation($this->l('Review description updated'));
               }

               if(Validate::isInt(Tools::getValue('CONNECTION_REQUIRED'))){
                    Configuration::updateValue('CONNECTION_REQUIRED', Tools::getValue('CONNECTION_REQUIRED'));
                    $output .= $this->displayConfirmation($this->l('Connection required updated'));
               }

               if(Validate::isInt(Tools::getValue('CAN_REVIEW_ARTICLE'))){
                    Configuration::updateValue('CAN_REVIEW_ARTICLE', Tools::getValue('CAN_REVIEW_ARTICLE'));
                    $output .= $this->displayConfirmation($this->l('Review possibility updated'));
               }
          }

          return $output.$this->displayForm();

     }


     

     public function displayForm(){

          $fieldsForm[0]['form'] = [ 
               'legend' => [
                    'title' => $this->l('Settings')
               ],
               'input' => [ 
                    [
                         'type' => 'text',
                         'label' => $this->l('Public title'),
                         'name' => 'REVIEW_TITLE',
                         'required' => true 
                    ],
                    [
                         'type' => 'textarea',
                         'label' => $this->l('Review description'),
                         'name' => 'REVIEW_DESCRIPTION',     
                         'autoload_rte' => true
                    ],
                    [
                         'type' => 'radio',
                         'label' => $this->l('Connection required ?'),
                         'name' => 'CONNECTION_REQUIRED',
                         'is_bool' => true,
                         'values' => array(
                              array(
                                        'id' => 'connexion_yes',
                                        'label' => $this->l('Yes'),
                                        'value' => 1
                                   ),
                              array(
                                        'id' => 'connexion_no',
                                        'label' => $this->l('No'),
                                        'value' => 0
                                   )
                         ),
                    ],
                    [
                         'type' => 'radio',
                         'label' => $this->l('Can review the article ?'),
                         'name' => 'CAN_REVIEW_ARTICLE',
                         'is_bool' => true,
                         'values' => array(
                              array(
                                        'id' => 'review_yes',
                                        'label' => $this->l('Yes'),
                                        'value' => 1
                                   ),
                              array(
                                        'id' => 'review_no',
                                        'label' => $this->l('No'),
                                        'value' => 0
                                   )
                         ),     
                    ],
               ],
               'submit' => [
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right'
               ]
          ];

          $helper = new HelperForm();
          // Hydratation
          $helper->module = $this;
          $helper->token = Tools::getAdminTokenLite('AdminModules'); 
          $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name; 
          $helper->title = $this->displayName;
          $helper->submit_action = 'submit'.$this->name; 
          
          $helper->fields_value['REVIEW_TITLE'] = Configuration::get('REVIEW_TITLE');
          $helper->fields_value['REVIEW_DESCRIPTION'] = Configuration::get('REVIEW_DESCRIPTION');
          $helper->fields_value['CONNECTION_REQUIRED'] = Configuration::get('CONNECTION_REQUIRED');
          $helper->fields_value['CAN_REVIEW_ARTICLE'] = Configuration::get('CAN_REVIEW_ARTICLE');

          return $helper->generateForm($fieldsForm); 
     }
}