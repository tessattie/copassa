<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Families Model
 *
 * @property \App\Model\Table\EmployeesTable&\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\Family newEmptyEntity()
 * @method \App\Model\Entity\Family newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Family[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Family get($primaryKey, $options = [])
 * @method \App\Model\Entity\Family findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Family patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Family[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Family|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Family saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Family[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Family[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Family[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Family[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FamiliesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('families');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('Transactions', [
            'foreignKey' => 'family_id',
        ]);

        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator->add('first_name', 'protect', [
            'rule' => function ($value, $context){
                $not_allowed = array("<script>", "</script>", "~", 'script');
                foreach($not_allowed as $character){
                    if(strpos($value, $character) !== FALSE){
                        return false;
                    }
                }
                return true;
            },
            'message' => 'The first name is not valid'
        ]);

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator->add('last_name', 'protect', [
            'rule' => function ($value, $context){
                $not_allowed = array("<script>", "</script>",  'script');
                foreach($not_allowed as $character){
                    if(strpos($value, $character) !== FALSE){
                        return false;
                    }
                }
                return true;
            },
            'message' => 'The last name is not valid'
        ]);

        $validator
            ->integer('relationship')
            ->requirePresence('relationship', 'create')
            ->notEmptyString('relationship');

        $validator
            ->numeric('premium')
            ->requirePresence('premium', 'create')
            ->notEmptyString('premium');

        $validator
            ->date('dob')
            ->requirePresence('dob', 'create')
            ->notEmptyDate('dob');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['employee_id'], 'Employees'), ['errorField' => 'employee_id']);

        return $rules;
    }
}
