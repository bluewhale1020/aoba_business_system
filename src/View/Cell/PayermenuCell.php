<?php
namespace App\View\Cell;

use Cake\View\Cell;
use Cake\ORM\TableRegistry;

/**
 * Payermenu cell
 */
class PayermenuCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        
       $this->Orders = TableRegistry::get('Orders'); 
       
       $payers = $this->Orders->getPayerCollection();

        // $payers = $this->Bills->find()
        // ->contain(['BusinessPartners'])
            // ->select(['business_partner_id','BusinessPartners.name'])
            // ->order(['business_partner_id' => 'ASC'])
            // ->group('business_partner_id')
            // ->all();
        
        $this->set('payers',$payers);

        
    }
}
