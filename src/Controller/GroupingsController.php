<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Groupings Controller
 *
 * @property \App\Model\Table\GroupingsTable $Groupings
 * @method \App\Model\Entity\Grouping[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupingsController extends AppController
{

    public function authorize(){
        if($this->Auth->user()['role_id'] == 2){

            if($this->request->getParam('action') == 'index' && ($this->authorizations[37] || $this->authorizations[38] || $this->authorizations[40])){
                return true;
            }

            if($this->request->getParam('action') == 'add' && $this->authorizations[38]){
                return true;
            }

            if($this->request->getParam('action') == 'addemployee' && $this->authorizations[38]){
                return true;
            }

            if($this->request->getParam('action') == 'edit' && $this->authorizations[38]){
                return true;
            }

            if($this->request->getParam('action') == 'delete' && $this->authorizations[38]){
                return true;
            }


            if($this->request->getParam('action') == 'view' && ($this->authorizations[37] || $this->authorizations[38] || $this->authorizations[40])){
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
        $groupings = $this->Groupings->find("all", array("conditions" => array("Groupings.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Employees' => ['Families'], 'Businesses', 'Companies']);

        $this->set(compact('groupings'));
    }

    /**
     * View method
     *
     * @param string|null $id Grouping id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $grouping = $this->Groupings->get($id, [
            'contain' => ['Businesses', 'Companies', 'Employees' => ['Families', 'Groupings' => ['Companies']]],
        ]);

        if($this->Auth->user()['tenant_id'] != $grouping->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        $this->set(compact('grouping'));
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
        $grouping = $this->Groupings->newEmptyEntity();
        if ($this->request->is('post')) {
            $grouping = $this->Groupings->patchEntity($grouping, $this->request->getData());
            $grouping->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Groupings->save($grouping)) {
                $this->Flash->success(__('The group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The group could not be saved. Please, try again.'));
        }
        $businesses = $this->Groupings->Businesses->find('list', ['order' => ['name ASC'], 'conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']]]);
        $companies = $this->Groupings->Companies->find('list', ['order' => ['name ASC'], 'conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']]]);
        $this->set(compact('grouping', 'businesses', 'companies'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addemployee()
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $employee = $this->Groupings->Employees->newEmptyEntity();
        if ($this->request->is('post')) {
            $employee = $this->Groupings->Employees->patchEntity($employee, $this->request->getData());
            $employee->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Groupings->Employees->save($employee)) {
                $this->loadModel("Families");
                $family = $this->Families->newEmptyEntity(); 
                $family->first_name = $ident['first_name'];
                $family->last_name = $ident['last_name'];
                $family->relationship = 4;
                $family->dob = $this->request->getData()['dob'];
                $family->premium = $this->request->getData()['premium']; 
                $family->employee_id = $ident['id']; 
                $family->tenant_id = $this->Auth->user()['tenant_id'];
                $family->gender = $this->request->getData()['gender']; 
                $family->country = $this->request->getData()['country'];
                $family->status = 1 ;
                $this->Families->save($family);
                return $this->redirect(['action' => 'view', $employee->grouping_id]);
            }
        }

        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string|null $id Grouping id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $grouping = $this->Groupings->get($id, [
            'contain' => [],
        ]);

        if($this->Auth->user()['tenant_id'] != $grouping->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $grouping = $this->Groupings->patchEntity($grouping, $this->request->getData());
            if ($this->Groupings->save($grouping)) {
                $this->Flash->success(__('The group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The group could not be saved. Please, try again.'));
        }
        $businesses = $this->Groupings->Businesses->find('list', ['order' => ['name ASC'], 'conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']]]);
        $companies = $this->Groupings->Companies->find('list', ['order' => ['name ASC'], 'conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']]]);
        $this->set(compact('grouping', 'businesses', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Grouping id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $this->request->allowMethod(['post', 'delete', 'get']);
        $grouping = $this->Groupings->get($id);

        if($this->Auth->user()['tenant_id'] != $grouping->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        if ($this->Groupings->delete($grouping)) {
            $this->Flash->success(__('The group has been deleted.'));
        } else {
            $this->Flash->error(__('The group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function list(){
        if($this->request->is(['ajax'])){
            $groupings = $this->Groupings->find("all", array("conditions" => array("business_id" => $this->request->getData()['business_id'], 'tenant_id' => $this->Auth->user()['tenant_id'])));
            echo json_encode($groupings->toArray()); 
        }
        die();
    }
}
