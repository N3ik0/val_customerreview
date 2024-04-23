<?php 

if(!defined('_PS_VERSION_')){
     exit;
}

require_once (_PS_MODULE_DIR_.'val_customerreview/classes/Review.php'); 

class Val_customerreviewListReviewModuleFrontController extends ModuleFrontController {

     public function initContent(){

          parent::initContent();

          $quote = Review::getQuoteByCustomer($this->context->customer->id);

          $this->context->smarty->assign(array(
               'quotes' => $quote
          ));

          $this->setTemplate('module:val_customerreview/views/templates/front/list.tpl');
     }

     public function postProcess(){

          if(Tools::getValue('action') == 'delete'){
               $id_review = Tools::getValue('id_review');
               $objreview = new Review($id_review);
               $objreview->delete();

               Tools::redirect($this->context->link->getModuleLink('val_customerreview', 'ListReview'));
          }

     }
}