<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Employees Controller
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $employees = $this->Employees->find("all", array('conditions' => array('Employees.tenant_id' => $this->Auth->user()['tenant_id'])))->contain(['Businesses', 'Groupings' => ['Companies']]);

        $this->set(compact('employees'));
    }

    public function report($group_id = false){
        $employees = array();
        $employees = $this->Employees->find("all")->contain(['Businesses', 'Families' => ['sort' => ['relationship DESC']], 'Groupings' => ['Companies']]); 
        $employees->where(['Employees.tenant_id' => $this->Auth->user()['tenant_id']]);
        if($this->request->is(['patch', 'put', 'post'])){
            if(!empty($this->request->getData()['business_id'])){
                $employees->where(['Employees.business_id' => $this->request->getData()['business_id']]);
            }
            if(!empty($this->request->getData()['grouping_id'])){
                $employees->where(['Employees.grouping_id' => $this->request->getData()['grouping_id']]);
            }
        }

         $businesses = $this->Employees->Businesses->find('list', ['conditions' => array('tenant_id' => $this->Auth->user()['tenant_id']), 'order' => 'name ASC']);
        $groupings = $this->Employees->Groupings->find('list', ['conditions' => array('tenant_id' => $this->Auth->user()['tenant_id']), 'order' => ['grouping_number ASC']]);
        $this->set(compact('employees', 'businesses', 'groupings'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => ['Businesses', 'Groupings', 'Families'],
        ]);

        $this->set(compact('employee'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employee = $this->Employees->newEmptyEntity();
        if ($this->request->is('post')) {
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());
            $employee->tenant_id = $this->Auth->user()['tenant_id'];
            if ($ident = $this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));
                    $this->loadModel("Families");
                    $family = $this->Families->newEmptyEntity(); 
                    $family->first_name = $ident['first_name'];
                    $family->last_name = $ident['last_name'];
                    $family->relationship = 4;
                    $family->tenant_id = $this->Auth->user()['tenant_id'];
                    $family->dob = $this->request->getData()['dob'];
                    $family->premium = $this->request->getData()['premium']; 
                    $family->employee_id = $ident['id']; 
                    $family->gender = $this->request->getData()['gender']; 
                    $family->country = $this->request->getData()['country'];
                    $family->status = 1 ;
                    $this->Families->save($family);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $businesses = $this->Employees->Businesses->find('list', ['order' => ['name ASC'], 'conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']]]);
        $this->set(compact('employee', 'businesses'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addfamily()
    {
        $family = $this->Employees->Families->newEmptyEntity();
        if ($this->request->is('post')) {
            $family = $this->Employees->Families->patchEntity($family, $this->request->getData());
            $family->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Employees->Families->save($family)) {
                return $this->redirect(['action' => 'view', $family->employee_id]);
            }
        }

        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $businesses = $this->Employees->Businesses->find('list', ['limit' => 200]);
        $groupings = $this->Employees->Groupings->find('list', ['limit' => 200, 'conditions' => ['business_id' => $employee->business_id]]);
        $this->set(compact('employee', 'businesses', 'groupings'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employee = $this->Employees->get($id);
        if ($this->Employees->delete($employee)) {
            $this->Flash->success(__('The employee has been deleted.'));
        } else {
            $this->Flash->error(__('The employee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function list(){
        if($this->request->is(['ajax'])){
            $employees = $this->Employees->find("all", array('order' => ['last_name ASC'], "conditions" => array("grouping_id" => $this->request->getData()['group_id'], 'tenant_id' => $this->Auth->user()['tenant_id'])));
            echo json_encode($employees->toArray()); 
        }
        die();
    }
}
