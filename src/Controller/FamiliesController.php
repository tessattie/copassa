<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Families Controller
 *
 * @property \App\Model\Table\FamiliesTable $Families
 * @method \App\Model\Entity\Family[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FamiliesController extends AppController
{

    public function authorize(){
        if($this->Auth->user()['role_id'] == 2){

            if($this->request->getParam('action') == 'index' && ($this->authorizations[37] || $this->authorizations[38] || $this->authorizations[40])){
                return true;
            }

            if($this->request->getParam('action') == 'add' && $this->authorizations[38]){
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
        $families = $this->Families->find("all", array("conditions" => array("Families.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Transactions', 'Employees' => ['Businesses', 'Groupings' => ['Companies']]]);

        $this->set(compact('families'));
    }

    /**
     * View method
     *
     * @param string|null $id Family id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $family = $this->Families->get($id, [
            'contain' => ['Employees'],
        ]);

        $this->set(compact('family'));
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
        $family = $this->Families->newEmptyEntity();
        if ($this->request->is('post')) {
            $family = $this->Families->patchEntity($family, $this->request->getData());
            if ($this->Families->save($family)) {
                $this->Flash->success(__('The family has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The family could not be saved. Please, try again.'));
        }
        $employees = $this->Families->Employees->find('list', ['order' => ['last_name ASC']]);
        $businesses = $this->Families->Employees->Businesses->find("list", ['order' => "name ASC"]);
        $this->set(compact('family', 'employees', 'businesses'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Family id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $family = $this->Families->get($id, [
            'contain' => ['Employees'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $family = $this->Families->patchEntity($family, $this->request->getData());
            if ($this->Families->save($family)) {
                $this->Flash->success(__('The family has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The family could not be saved. Please, try again.'));
        }
        $employees = $this->Families->Employees->find('list', ['order' => ['last_name ASC'], 'conditions' => ['grouping_id' => $family->employee->grouping_id]]);
        $businesses = $this->Families->Employees->Businesses->find("list", ['order' => "name ASC"]);
        $groups = $this->Families->Employees->Groupings->find("list", ['order' => ["grouping_number ASC"], 'conditions' => ['business_id' => $family->employee->business_id]]);
        $this->set(compact('family', 'employees', 'businesses', 'groups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Family id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $this->request->allowMethod(['post', 'delete', 'get']);
        $family = $this->Families->get($id);
        if ($this->Families->delete($family)) {
            $this->Flash->success(__('The family member has been deleted.'));
        } else {
            $this->Flash->error(__('The family member could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function list(){
        if($this->request->is(['ajax'])){
            $families = $this->Families->find("all", array('order' => ['last_name ASC'], "conditions" => array("employee_id" => $this->request->getData()['employee_id'])));
            echo json_encode($families->toArray()); 
        }
        die();
    }
}
