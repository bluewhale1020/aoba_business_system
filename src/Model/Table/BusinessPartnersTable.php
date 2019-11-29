<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BusinessPartners Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentBusinessPartners
 * @property \Cake\ORM\Association\HasMany $ChildBusinessPartners
 * @property \Cake\ORM\Association\HasMany $Bills
 * @property \Cake\ORM\Association\HasMany $ContractRates
 *
 * @method \App\Model\Entity\BusinessPartner get($primaryKey, $options = [])
 * @method \App\Model\Entity\BusinessPartner newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BusinessPartner[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BusinessPartner|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BusinessPartner patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BusinessPartner[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BusinessPartner findOrCreate($search, callable $callback = null)
 * 
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class BusinessPartnersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('business_partners');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');

        $this->belongsTo('ParentBusinessPartners', [
            'className' => 'BusinessPartners',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildBusinessPartners', [
            'className' => 'BusinessPartners',
            'foreignKey' => 'parent_id'
        ]);


        $this->hasMany('Bills', [
            'foreignKey' => 'business_partner_id'
        ]);
        $this->hasMany('Order1', [
            'className' => 'Orders',        
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('Order2', [
            'className' => 'Orders',        
            'foreignKey' => 'work_place_id'
        ]);                
        $this->hasMany('Order3', [
            'className' => 'Orders',        
            'foreignKey' => 'payer_id'
        ]);                
        $this->hasMany('ContractRates', [
            'foreignKey' => 'business_partner_id',
            'dependent' => true
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('kana');

        $validator
            ->allowEmpty('postal_code');

        $validator
            ->allowEmpty('address');

        $validator
            ->allowEmpty('banchi');

        $validator
            ->allowEmpty('tatemono');

        $validator
            ->allowEmpty('tel');

        $validator
            ->allowEmpty('fax');

        $validator
            ->allowEmpty('department');

        $validator
            ->allowEmpty('staff');

        $validator
            ->allowEmpty('staff_tel');

        $validator
            ->integer('is_client')
            ->allowEmpty('is_client');

        $validator
            ->integer('is_work_place')
            ->allowEmpty('is_work_place');

        $validator
            ->integer('is_supplier')
            ->allowEmpty('is_supplier');


        // $validator
            // ->add('lft', 'valid', ['rule' => 'numeric'])
        // //    ->requirePresence('lft', 'create')
            // ->notEmpty('lft');
     
        // $validator
            // ->add('rght', 'valid', ['rule' => 'numeric'])
        // //    ->requirePresence('rght', 'create')
            // ->notEmpty('rght');

        // 特定休日[20xx/xx/xx,20xx/xx/xx,..]の書式をチェック
        // 2019/10/01,2019/10/02,2019/10/03
        $validator->add('specific_holidays', 'myRule', [
            'rule' => function ($data, $provider) {
                $result = true;

                $dateArray = explode(",",$data);
                foreach($dateArray as $idx => $date){
                    if(!strtotime($date)){
                        $result = false;
                    }                
                }
                if($result){
                    return true;

                }else{

                    return '適切な年月書式ではありません。';
                }

            }
        ])->allowEmpty('specific_holidays');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parent_id'], 'ParentBusinessPartners'));

        return $rules;
    }


    /**
     * 検索用の[請負元id=>派遣先]リストを返す
     * 
     * @return array $sortedOptions [請負元id=>派遣先]リスト
     */
    public function getSortedOptions() {
        $workPlaceOptions = $this->find('all')->where(['WorkPlaces.is_work_place' => 1])->limit(200)->toArray();

        return $this->sortOptions($workPlaceOptions);

    }

     /**
     * 検索リストの整形
     * 
     * @param array $workPlaceOptions workplaceデータの配列
     * 
     * @return array $sortedOptions [請負元id=>派遣先]リスト
     */
    protected function sortOptions($workPlaceOptions)
    {
        $sortedOptions = [];
        foreach ($workPlaceOptions as $key => $workPlace) {
            if(empty($workPlace['parent_id'])){
                $sortedOptions[$workPlace['id']][] = $workPlace;
            }else{
                $sortedOptions[$workPlace['parent_id']][] = $workPlace;
            }
        }

        return $sortedOptions;
    }

    //インポートデータから
    //     定休日[日月火水木金土] を 0~6　の数字に
    public function import_check_holidays($rowdata){
        if(empty($rowdata['定休日'])){
            return $rowdata;
        }
        $holidays = explode(",",str_replace('、', ',', $rowdata['定休日']));

        $holiday_idcs = ['日'=>0,'月'=>1,'火'=>2,'水'=>3,'木'=>4,'金'=>5,'土'=>6];
        $holiday_nums = [];
        foreach($holidays as $idx => $value){
            if(!empty($holiday_idcs[$value]) or $holiday_idcs[$value] === 0){
                $holiday_nums[] = $holiday_idcs[$value];
            }
        }
        if(empty($holiday_nums)){
            $rowdata['定休日'] = "";
        }else{
            $rowdata['定休日'] = implode("," ,$holiday_nums);
        }

        return $rowdata;
    }

    //名称で検索し、登録済みなら該当エンティティを、無ければ新規エンティティを返す
    public function findOrNew($name){
        $result = $this->find()->where(['name'=>$name])->first();

        if($result){
            return $result;
        }else{
            return $this->newEntity();
        }

    }
}
