<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Prenewals Model
 *
 * @property \App\Model\Table\PoliciesTable&\Cake\ORM\Association\BelongsTo $Policies
 *
 * @method \App\Model\Entity\Prenewal newEmptyEntity()
 * @method \App\Model\Entity\Prenewal newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Prenewal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Prenewal get($primaryKey, $options = [])
 * @method \App\Model\Entity\Prenewal findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Prenewal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Prenewal[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Prenewal|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Prenewal saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Prenewal[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Prenewal[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Prenewal[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Prenewal[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PrenewalsTable extends Table
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

        $this->setTable('prenewals');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Policies', [
            'foreignKey' => 'policy_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('Files', [
            'foreignKey' => 'prenewal_id',
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
            ->date('renewal_date')
            ->requirePresence('renewal_date', 'create')
            ->notEmptyDate('renewal_date');

        $validator
            ->numeric('premium')
            ->requirePresence('premium', 'create')
            ->notEmptyString('premium');

        $validator
            ->numeric('fee')
            ->allowEmptyString('fee');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        $validator
            ->integer('polucy_status')
            ->notEmptyString('policy_status');

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
        $rules->add($rules->existsIn(['policy_id'], 'Policies'), ['errorField' => 'policy_id']);

        return $rules;
    }
}
