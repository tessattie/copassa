<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Businesses Controller
 *
 * @property \App\Model\Table\BusinessesTable $Businesses
 * @method \App\Model\Entity\Business[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BusinessesController extends AppController
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

            if($this->request->getParam('action') == 'addgroup' && $this->authorizations[38]){
                return true;
            }

            if($this->request->getParam('action') == 'addemployee' && $this->authorizations[38]){
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
        $businesses = $this->Businesses->find("all", array("conditions" => array("Businesses.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Renewals', 'Groupings' => ['Employees' => ['Families']]]);

        $this->set(compact('businesses'));
    }

    /**
     * View method
     *
     * @param string|null $id Business id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $business = $this->Businesses->get($id, [
            'contain' => ['Employees' => ['Groupings' => ['Companies'], 'Families'], 'Groupings' => ['Employees' => ['Families'], 'Companies' => ['Countries']]],
        ]);

        $companies = $this->Businesses->Groupings->Companies->find('list', array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id']), "order" => array("name ASC")));

        $groupings = $this->Businesses->Groupings->find('list', array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id']), "order" => array("grouping_number ASC")));

        $this->set(compact('business','companies', 'groupings'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $business = $this->Businesses->newEmptyEntity();
        if ($this->request->is('post')) {
            $business = $this->Businesses->patchEntity($business, $this->request->getData());
            $business->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Businesses->save($business)) {
                $this->Flash->success(__('The business has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The business could not be saved. Please, try again.'));
        }
        $this->set(compact('business'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addgroup()
    {
        $group = $this->Businesses->Groupings->newEmptyEntity();
        if ($this->request->is('post')) {
            $group = $this->Businesses->Groupings->patchEntity($group, $this->request->getData());
            $group->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Businesses->Groupings->save($group)) {
                return $this->redirect(['action' => 'view', $group->business_id]);
            }
        }

        return $this->redirect($this->referer());
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addemployee()
    {
        $employee = $this->Businesses->Groupings->Employees->newEmptyEntity();
        if ($this->request->is('post')) {
            $employee = $this->Businesses->Groupings->Employees->patchEntity($employee, $this->request->getData());
            $employee->tenant_id = $this->Auth->user()['tenant_id'];
            if ($ident = $this->Businesses->Groupings->Employees->save($employee)) {
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
                return $this->redirect(['action' => 'view', $employee->business_id]);
            }
        }

        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string|null $id Business id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $business = $this->Businesses->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $business = $this->Businesses->patchEntity($business, $this->request->getData());
            if ($this->Businesses->save($business)) {
                $this->Flash->success(__('The business has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The business could not be saved. Please, try again.'));
        }
        $this->set(compact('business'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Business id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $business = $this->Businesses->get($id);
        if ($this->Businesses->delete($business)) {
            $this->Flash->success(__('The business has been deleted.'));
        } else {
            $this->Flash->error(__('The business could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function getbusiness(){
        if($this->request->is(['ajax'])){
            $business = $this->Businesses->get($this->request->getData()['business_id']);
            echo json_encode($business); 
        }
        die();
    }
}
