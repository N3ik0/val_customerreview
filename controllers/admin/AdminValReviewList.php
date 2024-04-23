<?php

if(!defined('_PS_VERSION_')){
    exit;
}

require_once _PS_MODULE_DIR_.'val_customerreview/classes/Review.php';


class AdminValReviewListController extends ModuleAdminController {

    public function __construct(){
        $this->table = 'review';
        $this->className = 'Review';
        $this->lang = false;
        $this->deleted = false;
        $this->colorOnBackground = false;
        $this->context = Context::getContext();
        $this->bootstrap = true;

        parent::__construct();

    }

    public function renderList(){
        $this->fields_list = array(
            'id_review' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'id_product' => array(
                'title' => $this->l('ID Product'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'id_customer' => array(
                'title' => $this->l('ID Customer'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'note' => array(
                'title' => $this->l('Note'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'comment' => array(
                'title' => $this->l('Comment'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'date_add' => array(
                'title' => $this->l('Date'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'name_customer' => array(
                'title' => $this->l('Name'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'surname_customer' => array(
                'title' => $this->l('Surname'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'email_customer' => array(
                'title' => $this->l('Email'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            )
        );

        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?')
            )
        );

    $this->addRowAction('edit');
    $this->addRowAction('delete');

    return parent::renderList();
    }

    public function renderForm(){

        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Review'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('ID Product'),
                    'name' => 'id_product',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('ID Customer'),
                    'name' => 'id_customer',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Note'),
                    'name' => 'note',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Comment'),
                    'name' => 'comment',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Date'),
                    'name' => 'date_add',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Name'),
                    'name' => 'name_customer',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Surname'),
                    'name' => 'surname_customer',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Email'),
                    'name' => 'email_customer',
                    'required' => true
                )
            ),
            'submit' => array(
                'title' => $this->l('Save')
            )
        );

        return parent::renderForm();
    }

}