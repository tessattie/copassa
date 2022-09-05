<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Elements Model
 *
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 *
 * @method \App\Model\Entity\Element newEmptyEntity()
 * @method \App\Model\Entity\Element newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Element[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Element get($primaryKey, $options = [])
 * @method \App\Model\Entity\Element findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Element patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Element[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Element|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Element saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Element[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Element[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Element[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Element[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ElementsTable extends Table
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

        $this->setTable('elements');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator->add('name', 'protect', [
            'rule' => function ($value, $context){
                $not_allowed = array("<script>", "#", "</script>", "*", "<", "=", ">", "[", "]", "^", "{", "}", "~", 'script');
                foreach($not_allowed as $character){
                    if(strpos($value, $character) !== FALSE){
                        return false;
                    }
                }
                return true;
            },
            'message' => 'The name is not valid'
        ]);

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator->add('title', 'protect', [
            'rule' => function ($value, $context){
                $not_allowed = array("<script>", "#", "</script>", "*", "<", "=", ">", "[", "]", "^", "{", "}", "~", 'script');
                foreach($not_allowed as $character){
                    if(strpos($value, $character) !== FALSE){
                        return false;
                    }
                }
                return true;
            },
            'message' => 'The title is not valid'
        ]);

        $validator
            ->scalar('subtitle')
            ->maxLength('subtitle', 255)
            ->allowEmptyString('subtitle');

        $validator->add('subtitle', 'protect', [
            'rule' => function ($value, $context){
                $not_allowed = array("<script>", "#", "</script>", "*", "<", "=", ">", "[", "]", "^", "{", "}", "~", 'script');
                foreach($not_allowed as $character){
                    if(strpos($value, $character) !== FALSE){
                        return false;
                    }
                }
                return true;
            },
            'message' => 'The subtitle is not valid'
        ]);

        $validator
            ->scalar('video')
            ->maxLength('video', 255)
            ->allowEmptyString('video');

        $validator
            ->scalar('photo')
            ->maxLength('photo', 255)
            ->allowEmptyString('photo');

        $validator
            ->scalar('text')
            ->maxLength('text', 255)
            ->allowEmptyString('text');

        $validator->add('text', 'protect', [
            'rule' => function ($value, $context){
                $not_allowed = array("<script>", "#", "</script>", "*", "<", "=", ">", "[", "]", "^", "{", "}", "~", 'script');
                foreach($not_allowed as $character){
                    if(strpos($value, $character) !== FALSE){
                        return false;
                    }
                }
                return true;
            },
            'message' => 'The text is not valid'
        ]);

        $validator
            ->integer('position')
            ->requirePresence('position', 'create')
            ->notEmptyString('position');

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
        $rules->add($rules->existsIn(['category_id'], 'Categories'), ['errorField' => 'category_id']);

        return $rules;
    }
}
