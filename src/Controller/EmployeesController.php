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
        $employees = $this->Employees->find("all")->contain(['Businesses', 'Groupings' => ['Companies']]);

        $this->set(compact('employees'));
    }

    public function report($group_id = false){
        $employees = array();
        $employees = $this->Employees->find("all")->contain(['Businesses', 'Families' => ['sort' => ['relationship DESC']], 'Groupings' => ['Companies']]); 
        if($group_id){
           $employees = $this->Employees->find("all")->contain(['Businesses', 'Families', 'Groupings' => ['Companies']]); 
        }
        $this->set(compact('employees'));
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
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $businesses = $this->Employees->Businesses->find('list', ['limit' => 200]);
        $groupings = $this->Employees->Groupings->find('list', ['limit' => 200]);
        $this->set(compact('employee', 'businesses', 'groupings'));
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
            $employees = $this->Employees->find("all", array('order' => ['last_name ASC'], "conditions" => array("grouping_id" => $this->request->getData()['group_id'])));
            echo json_encode($employees->toArray()); 
        }
        die();
    }
}
