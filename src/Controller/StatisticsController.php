<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Statistics Controller
 *
 *
 * @method \App\Model\Entity\Statistic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StatisticsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->EquipmentRentals = TableRegistry::get('EquipmentRentals');

        $this->loadComponent('Date');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $year = $this->Date->getFiscalYear();

        $this->set(compact('year'));
    }

    function ajaxloadoperationnumbers(){

        // ajaxによる呼び出し？
        if ($this->request->is("ajax")) {
            $start_year = (int)$_POST['start_year'];
            $start_mon = (int)$_POST['start_mon'];
            $end_year = (int)$_POST['end_year'];
            $end_mon = (int)$_POST['end_mon'];

            //グラフのX軸データを期間から作成
            $m = $start_mon;
            $y = $start_year;
            $x_scale = [];
            while($end_year > $y || ($end_year === $y && $end_mon >= $m) ){
                $x_scale[$y][] = $m;
                $m++;
              if($m > 12){ // loop to the next year
                $m = 1;
                $y++;
              }
            }            


            $start_date = new \DateTime($start_year."-".$start_mon."-1");
            $end_date =  new \DateTime($end_year."-".$end_mon."-1");
            
            //装置レンタルテーブルから稼働数データを取得
            $counts = $this->EquipmentRentals->getOperationInfo($start_date, $end_date);

            $data = [];                                        
            // (int) 2019 => [(int) 10 => ['counts' => [
            //             (int) 0 => (int) 2,
            //             (int) 1 => (int) 0,
            //             ~~~
            //             (int) 9 => (int) 0
            //  ] ]]
            //　取得した稼働数データをX軸データに合わせてグラフデータを生成
            foreach ($x_scale as $year => $months) {
                foreach ($months as $key => $month) {
                    $temp = ["year"=>$year,"month"=>$month,"counts"=>[0,0,0,0,0,0,0,0,0,0]];
                    if(!empty($counts[$year][$month])){
                        $temp['counts'] = $counts[$year][$month]['counts'];
                    }
                    $data[] = $temp;
                }
            }
            $this->set('result',['chartdata'=>$data]);      

        }
  
}  



    /**
     * View method
     *
     * @param string|null $id Statistics Controller id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $statistics = $this->Statistics->get($id, [
            'contain' => []
        ]);

        $this->set('statistics', $statistics);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $statistics = $this->Statistics->newEntity();
        if ($this->request->is('post')) {
            $statistics = $this->Statistics->patchEntity($statistics, $this->request->getData());
            if ($this->Statistics->save($statistics)) {
                $this->Flash->success(__('The statistics has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The statistics could not be saved. Please, try again.'));
        }
        $this->set(compact('statistics'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Statistics id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $statistics = $this->Statistics->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $statistics = $this->Statistics->patchEntity($statistics, $this->request->getData());
            if ($this->Statistics->save($statistics)) {
                $this->Flash->success(__('The statistics has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The statistics could not be saved. Please, try again.'));
        }
        $this->set(compact('statistics'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Statistics id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $statistics = $this->Statistics->get($id);
        if ($this->Statistics->delete($statistics)) {
            $this->Flash->success(__('The statistics has been deleted.'));
        } else {
            $this->Flash->error(__('The statistics could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
