<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tenants Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\Tenant newEmptyEntity()
 * @method \App\Model\Entity\Tenant newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Tenant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tenant get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tenant findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Tenant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tenant[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tenant|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tenant saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tenant[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tenant[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tenant[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tenant[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TenantsTable extends Table
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

        $this->setTable('tenants');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Businesses', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Companies', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Countries', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Customers', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Dependants', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Employees', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Families', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Files', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Folders', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Groupings', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Logs', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Newborns', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Notes', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Options', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Pendings', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Policies', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Renewals', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Riders', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Transactions', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'tenant_id',
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
            ->scalar('full_name')
            ->maxLength('full_name', 255)
            ->requirePresence('full_name', 'create')
            ->notEmptyString('full_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 255)
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone');

        $validator
            ->scalar('identification')
            ->maxLength('identification', 255)
            ->requirePresence('identification', 'create')
            ->notEmptyString('identification');

        $validator
            ->scalar('company')
            ->maxLength('company', 255)
            ->requirePresence('company', 'create')
            ->notEmptyString('company');

        $validator
            ->notEmptyString('status');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
