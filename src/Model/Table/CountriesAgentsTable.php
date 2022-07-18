<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CountriesAgents Model
 *
 * @property \App\Model\Table\CountriesTable&\Cake\ORM\Association\BelongsTo $Countries
 * @property \App\Model\Table\AgentsTable&\Cake\ORM\Association\BelongsTo $Agents
 *
 * @method \App\Model\Entity\CountriesAgent newEmptyEntity()
 * @method \App\Model\Entity\CountriesAgent newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CountriesAgent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CountriesAgent get($primaryKey, $options = [])
 * @method \App\Model\Entity\CountriesAgent findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CountriesAgent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CountriesAgent[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CountriesAgent|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CountriesAgent saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CountriesAgent[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CountriesAgent[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CountriesAgent[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CountriesAgent[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CountriesAgentsTable extends Table
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

        $this->setTable('countries_agents');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Agents', [
            'foreignKey' => 'agent_id',
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
        $rules->add($rules->existsIn(['country_id'], 'Countries'), ['errorField' => 'country_id']);
        $rules->add($rules->existsIn(['agent_id'], 'Agents'), ['errorField' => 'agent_id']);

        return $rules;
    }
}
