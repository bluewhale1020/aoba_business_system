<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * Equipments Controller
 *
 * @property \App\Model\Table\EquipmentsTable $Equipments
 */
class EquipmentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        
       // debug($this->request->data);
        
        if($this->request->is('post')){
            //データを検索する
            $conditions = [];
            //装置種類
            if(!empty($this->request->data['装置種類'])){
                $conditions[] = ['equipment_type_id' => $this->request->data['装置種類']];                
            }
            
            //撮影種類
            if(!empty($this->request->data['撮影種類'])){
                $conditions[] = ['xray_type_id' => $this->request->data['撮影種類']];                
            }            
            //状態
            if(!empty($this->request->data['状態'])){
                $conditions[] = ['status_id' => $this->request->data['状態']];                
            }           
         
            $equipments = $this->Equipments->find()
            ->contain(['EquipmentTypes','XrayTypes','Statuses'])
            ->where($conditions)
            //->order(['Users.name' => 'ASC'])
            //->select([fieldName])
            ->all();
            
                
        // $this->paginate = [
            // 'contain' => ['EquipmentTypes', 'Statuses']
        // ];
        //$equipments = $this->paginate($this->Equipments);

           
            
        }else{
             $equipments = $this->Equipments->find()
             ->contain(['EquipmentTypes','XrayTypes','Statuses'])
            ->all();           
        }

        $this->set(compact('equipments'));
        $this->set('_serialize', ['equipments']);  
               
        //$table = TableRegistry::get('EquipmentTypes');
        $equipmentTypes = $this->Equipments->EquipmentTypes->find('list', ['limit' => 200]);
        $xrayTypes = $this->Equipments->XrayTypes->find('list', ['limit' => 200]);
        $statuses = $this->Equipments->Statuses->find('list', ['limit' => 200]);
        $this->set(compact( 'equipmentTypes','xrayTypes', 'statuses'));        

        
    }

    /**
     * View method
     *
     * @param string|null $id Equipment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $equipment = $this->Equipments->get($id, [
            'contain' => ['EquipmentTypes', 'XrayTypes','Statuses']
        ]);

        //貸出履歴
        $this->EquipmentRentals = TableRegistry::get('EquipmentRentals');
        $eRentals = $this->EquipmentRentals->getRentalHistory($equipment->id);

        $this->set(compact( 'equipment', 'eRentals'));
        $this->set('_serialize', ['equipment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $equipment = $this->Equipments->newEntity();
        if ($this->request->is('post')) {
            $equipment = $this->Equipments->patchEntity($equipment, $this->request->data);
            if ($this->Equipments->save($equipment)) {
                $this->Flash->success(__('新しい装備を登録しました。'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('装備の新規登録に失敗しました。再度やり直してください。'));
            }
        }
        $equipmentTypes = $this->Equipments->EquipmentTypes->find('list', ['limit' => 200]);
        $xrayTypes = $this->Equipments->XrayTypes->find('list', ['limit' => 200]);        
        $statuses = $this->Equipments->Statuses->find('list', ['limit' => 200]);
        $this->set(compact('equipment', 'equipmentTypes','xrayTypes', 'statuses'));
        $this->set('_serialize', ['equipment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Equipment id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $equipment = $this->Equipments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $equipment = $this->Equipments->patchEntity($equipment, $this->request->data);
            if ($this->Equipments->save($equipment)) {
                $this->Flash->success(__('装置情報を更新しました。'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('装置情報の更新に失敗しました。再度やり直してください。'));
            }
        }
        $equipmentTypes = $this->Equipments->EquipmentTypes->find('list', ['limit' => 200]);
        $xrayTypes = $this->Equipments->XrayTypes->find('list', ['limit' => 200]);          
        $statuses = $this->Equipments->Statuses->find('list', ['limit' => 200]);
        $this->set(compact('equipment', 'equipmentTypes','xrayTypes', 'statuses'));
        $this->set('_serialize', ['equipment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Equipment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $equipment = $this->Equipments->get($id);
        if ($this->Equipments->delete($equipment)) {
            $this->Flash->success(__('選択した装置情報を削除しました。'));
        } else {
            $this->Flash->error(__('選択した装置の削除に失敗しました。再度やり直してください。'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
