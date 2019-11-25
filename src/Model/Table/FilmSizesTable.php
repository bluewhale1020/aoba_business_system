<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FilmSizes Model
 *
 * @property \Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\FilmSize get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilmSize newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FilmSize[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilmSize|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilmSize patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilmSize[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilmSize findOrCreate($search, callable $callback = null)
 */
class FilmSizesTable extends Table
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

        $this->table('film_sizes');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Orders', [
            'foreignKey' => 'film_size_id'
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
            ->allowEmpty('name');

        return $validator;
    }
}
