<?php 

if(!defined('_PS_VERSION_')){
     exit;
}

require_once (_PS_MODULE_DIR_.'val_customerreview/classes/Review.php');

class Val_customerreviewFormReviewModuleFrontController extends ModuleFrontController {

    public function initContent(){
        parent::initContent();
    
        if(Tools::getValue('confirmation')){
            $this->context->smarty->assign(array(
                'confirmation' => 1
            ));
        }
        
        $id_product = Tools::getValue('id_product');
        $product = new Product($id_product, false, $this->context->shop->id);
        
        $id_review = Tools::getValue('id_review');
    
        $review = Review::getQuoteByReview($id_review);
        
        $this->context->smarty->assign(array(
            'product' => $product,
            'review' => $review,
        ));
        
        $this->setTemplate('module:val_customerreview/views/templates/front/formReview.tpl');
    }

    public function postProcess(){
        if(Tools::isSubmit('submit_review')){
            $message = Tools::getValue('comment');
            $customerid = $this->context->customer->id;
            $id_product = Tools::getValue('id_product');
            $note = Tools::getValue('note');
            $name = $this->context->customer->firstname;
            $surname = $this->context->customer->lastname;
            $email = $this->context->customer->email;
    
            $existingReviews = Review::getQuote($id_product); 
    
            $existingReview = null;
            foreach ($existingReviews as $review) {
                if ($review['id_customer'] == $customerid) {
                    $existingReview = $review;
                    break;
                }
            }
    
            if ($existingReview && $existingReview['comment'] != $message) {

                $review = new Review((int)$existingReview['id_review']);
    
                $review->id_product = $id_product;
                $review->id_customer = $customerid;
                $review->note = $note;
                $review->comment = $message;
                $review->name_customer = $name;
                $review->surname_customer = $surname;
                $review->email_customer = $email;
    
                // Update the review in the database
                $resultReview = $review->update();
    
                if(!$resultReview){
                    $this->errors[] = Tools::displayError('Le commentaire n\'à pas été mis à jour');
                } else {
                    Tools::redirect($this->context->link->getModuleLink('val_customerreview', 'FormReview', array('confirmation' => 1, 'id_product' => $id_product)));
                }
            } else {
                $review = new Review();
                $review->id_product = $id_product;
                $review->id_customer = $customerid;
                $review->note = $note;
                $review->comment = $message;
                $review->name_customer = $name;
                $review->surname_customer = $surname;
                $review->email_customer = $email;
    
                $resultReview = $review->add();
    
                if(!$resultReview){
                    $this->errors[] = Tools::displayError('Le commentaire n\'à pas été enregistré');
                } else {
                    Tools::redirect($this->context->link->getModuleLink('val_customerreview', 'FormReview', array('confirmation' => 1, 'id_product' => $id_product)));
                }
            }
        }
    }


}