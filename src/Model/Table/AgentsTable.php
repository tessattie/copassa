<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Agents Model
 *
 * @property \App\Model\Table\CountriesTable&\Cake\ORM\Association\BelongsTo $Countries
 *
 * @method \App\Model\Entity\Agent newEmptyEntity()
 * @method \App\Model\Entity\Agent newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Agent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Agent get($primaryKey, $options = [])
 * @method \App\Model\Entity\Agent findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Agent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Agent[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Agent|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Agent saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Agent[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Agent[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Agent[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Agent[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class AgentsTable extends Table
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

        $this->setTable('agents');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

    
        $this->hasMany('Customers', [
            'foreignKey' => 'agent_id',
        ]);

        $this->hasMany('CountriesAgents', [
            'foreignKey' => 'agent_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 255)
            ->allowEmptyString('phone');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        return $validator;
    }

}
