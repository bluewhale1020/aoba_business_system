<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ContractRates Controller
 *
 * @property \App\Model\Table\ContractRatesTable $ContractRates
 */
class ContractRatesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    // public function index()
    // {
    //     $this->paginate = [
    //         'contain' => ['BusinessPartners']
    //     ];
    //     $contractRates = $this->paginate($this->ContractRates);

    //     $this->set(compact('contractRates'));
    //     $this->set('_serialize', ['contractRates']);
    // }

    /**
     * View method
     *
     * @param string|null $id Contract Rate id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null)
    // {
    //     $contractRate = $this->ContractRates->get($id, [
    //         'contain' => ['BusinessPartners']
    //     ]);

    //     $this->set('contractRate', $contractRate);
    //     $this->set('_serialize', ['contractRate']);
    // }


    /**
     * Manage method
     *
     */
    public function manage($business_partner_id = null)
    {
        if(!empty($business_partner_id)){
            $contractRate = $this->ContractRates->find()
            //->contain(['Address'])
            ->where(['ContractRates.business_partner_id' => $business_partner_id])
            ->first();
            
            if($contractRate){
                return $this->redirect(['action' => 'edit',$contractRate->id,$business_partner_id]);
            }else{
                return $this->redirect(['action' => 'add',$business_partner_id]);
            }
                       
        }else{
            $this->Flash->error(__('料金を設定する取引先IDが存在しません。'));
            return $this->redirect(['controller' => 'BusinessPartners','action' => 'index']);
        }

    }


    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($business_partner_id = null)
    {
        $contractRate = $this->ContractRates->newEntity();
        if ($this->request->is('post')) {
            $contractRate = $this->ContractRates->patchEntity($contractRate, $this->request->data);
            if ($this->ContractRates->save($contractRate)) {
                $this->Flash->success(__('業務契約の料金を設定しました。'));

            //   if(empty($business_partner_id)){
            //         return $this->redirect(['action' => 'view',$contractRate->id]);
            //     }else{
                return $this->redirect(['controller'=>'BusinessPartners','action' => 'view',$business_partner_id]);
                // }

            } else {
                $this->Flash->error(__('業務契約料金の設定に失敗しました。再度やり直してください。'));
            }
        }

        $contractRate->business_partner_id = $business_partner_id;


        $businessPartners = $this->ContractRates->BusinessPartners->find('list', ['limit' => 200])->toArray();
        $this->set(compact('contractRate', 'businessPartners'));
        $this->set('_serialize', ['contractRate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Contract Rate id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null,$business_partner_id = null)
    {
        $contractRate = $this->ContractRates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractRate = $this->ContractRates->patchEntity($contractRate, $this->request->data);
            if ($this->ContractRates->save($contractRate)) {
                $this->Flash->success(__('業務契約の料金を更新しました。'));
                
            //   if(empty($business_partner_id)){
            //         return $this->redirect(['action' => 'view',$id]);
            //     }else{
                return $this->redirect(['controller'=>'BusinessPartners','action' => 'view',$business_partner_id]);
                // }
            } else {
                $this->Flash->error(__('業務契約料金の更新に失敗しました。再度やり直してください。'));
            }
        }
        $businessPartners = $this->ContractRates->BusinessPartners->find('list', ['limit' => 200])->toArray();
        $this->set(compact('contractRate', 'businessPartners'));
        $this->set('_serialize', ['contractRate']);
    }


    /**
     * Delete method
     *
     * @param string|null $id Contract Rate id.
     * @return \Cake\Network\Response|null Redirects to BusinessPartnersview.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($business_partner_id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contractRate = $this->ContractRates->find()
        //->contain(['Address'])
        ->where(['ContractRates.business_partner_id' => $business_partner_id])
        ->first();
        if ($contractRate and $this->ContractRates->delete($contractRate)) {
            $this->Flash->success(__('業務契約の料金設定をクリアしました。'));
        } else {
            $this->Flash->error(__('業務契約料金の設定クリアに失敗しました。再度やり直してください。'));
        }

        return $this->redirect(['controller'=>'BusinessPartners','action' => 'view',$business_partner_id]);
    }


    function ajaxloadcontractrates(){     

        // ajaxによる呼び出し？
        if($this->request->is("ajax")) {
          $business_partner_id = $this->request->data['client_id'];

          
          $contractRate = $this->ContractRates
            ->find()
            ->where(['business_partner_id'=>$business_partner_id])
            ->first();
         
            if(!$contractRate){
                $this->response->type('json');
                $this->response->statusCode(400);
                echo json_encode(['message' => __('指定の取引先の契約料金は登録されていません！')]);
                return $this->response;                                             
            }else{                    
                return $this->response->withStringBody(json_encode($contractRate));                 
            }
            // $this->set('result',$contractRate);      
        }   
    
}    

    
}
