<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Policies Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\OptionsTable&\Cake\ORM\Association\BelongsTo $Options
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PaymentsTable&\Cake\ORM\Association\HasMany $Payments
 *
 * @method \App\Model\Entity\Policy newEmptyEntity()
 * @method \App\Model\Entity\Policy newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Policy[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Policy get($primaryKey, $options = [])
 * @method \App\Model\Entity\Policy findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Policy patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Policy[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Policy|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Policy saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Policy[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Policy[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Policy[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Policy[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PoliciesTable extends Table
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

        $this->setTable('policies');
        $this->setDisplayField('policy_number');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('Options', [
            'foreignKey' => 'option_id',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'policy_id',
        ]);
        $this->hasMany('Prenewals', [
            'foreignKey' => 'policy_id',
        ]);
        $this->hasMany('PoliciesRiders', [
            'foreignKey' => 'policy_id',
        ]);
        $this->hasMany('Dependants', [
            'foreignKey' => 'policy_id',
        ]);

        $this->hasMany('Claims', [
            'foreignKey' => 'policy_id',
        ]);

        $this->hasMany('Files', [
            'foreignKey' => 'policy_id',
        ]);

        $this->hasMany('Prenewals', [
            'foreignKey' => 'policy_id',
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
            ->scalar('policy_number')
            ->maxLength('policy_number', 255)
            ->requirePresence('policy_number', 'create')
            ->notEmptyString('policy_number');

        $validator
            ->integer('mode')
            ->requirePresence('mode', 'create')
            ->notEmptyString('mode');

        $validator
            ->date('effective_date')
            ->requirePresence('effective_date', 'create')
            ->notEmptyDate('effective_date');

        $validator
            ->date('paid_until')
            ->requirePresence('paid_until', 'create')
            ->notEmptyDate('paid_until');

        $validator
            ->numeric('premium')
            ->requirePresence('premium', 'create')
            ->notEmptyString('premium');

        $validator
            ->numeric('fee')
            ->notEmptyString('fee');

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
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);
        $rules->add($rules->existsIn(['option_id'], 'Options'), ['errorField' => 'option_id']);
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
