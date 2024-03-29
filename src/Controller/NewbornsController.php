<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Newborns Controller
 *
 * @property \App\Model\Table\NewbornsTable $Newborns
 * @method \App\Model\Entity\Newborn[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NewbornsController extends AppController
{

    public function authorize(){
        if($this->Auth->user()['role_id'] == 2){

            if($this->request->getParam('action') == 'index' && ($this->authorizations[30] || $this->authorizations[31])){
                return true;
            }

            if($this->request->getParam('action') == 'add' && $this->authorizations[31]){
                return true;
            }

            if($this->request->getParam('action') == 'edit' && $this->authorizations[31]){
                return true;
            }

            if($this->request->getParam('action') == 'adddependant' && $this->authorizations[31]){
                return true;
            }

            if($this->request->getParam('action') == 'delete' && $this->authorizations[31]){
                return true;
            }

            return false;

        }else{

            return true;

        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $filter_country = $this->session->read("filter_country");
        $newborns = $this->Newborns->find('all', array("conditions" => array("Newborns.status" => 1, 'Newborns.tenant_id' => $this->Auth->user()['tenant_id']), "order" => array('Newborns.created ASC')))->contain(['Policies' => ['Customers' => ['Countries'], 'Companies', 'Options'], 'Users']);
        $customers = $this->Newborns->Policies->Customers->find("list", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id']), "order" => array('name ASC') ));
        $this->set(compact('newborns', 'customers', 'filter_country'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        if ($this->request->is('post')) {
            // debug($this->request->getData()); die();
            $newborn = $this->Newborns->newEmptyEntity();
            $newborn = $this->Newborns->patchEntity($newborn, $this->request->getData());
            $newborn->status = 1; 
            $newborn->tenant_id = $this->Auth->user()['tenant_id'];
            $newborn->user_id = $this->Auth->user()['id'];
            $this->Newborns->save($newborn);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Newborn id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $newborn = $this->Newborns->get($id, [
            'contain' => [],
        ]);

        if($this->Auth->user()['tenant_id'] != $newborn->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $newborn = $this->Newborns->patchEntity($newborn, $this->request->getData());
            if ($this->Newborns->save($newborn)) {
                $this->Flash->success(__('The newborn has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The newborn could not be saved. Please, try again.'));
        }
        $policies = $this->Newborns->Policies->find('list', ['limit' => 200]);
        $users = $this->Newborns->Users->find('list', ['limit' => 200]);
        $this->set(compact('newborn', 'policies', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Newborn id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $this->request->allowMethod(['post', 'delete', 'get']);
        $newborn = $this->Newborns->get($id);

        if($this->Auth->user()['tenant_id'] != $newborn->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        $this->Newborns->delete($newborn);

        return $this->redirect(['action' => 'index']);
    }


    public function adddependant(){
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        if($this->request->is(['patch', 'put', 'post'])){

            // update newborn status
            $newborn = $this->Newborns->get($this->request->getData()['newborn_id']);
            $newborn->status = 2; 
            $this->Newborns->save($newborn); 

            $this->loadmodel('Dependants'); 
            $dependant = $this->Dependants->newEmptyEntity(); 
            $dependant->name = $this->request->getData()['name'];
            $dependant->tenant_id = $this->Auth->user()['tenant_id'];
            $dependant->sexe = $this->request->getData()['sexe'];
            $dependant->relation = $this->request->getData()['relation'];
            $dependant->dob = $this->request->getData()['dob'];
            $dependant->limitations = $this->request->getData()['limitations'];
            $dependant->policy_id = $this->request->getData()['policy_id'];
            $dependant->user_id = $this->Auth->user()['id'];
            $this->Dependants->save($dependant);
            // add dependant
        }

        return $this->redirect(['action' => 'index']);
    }
}
