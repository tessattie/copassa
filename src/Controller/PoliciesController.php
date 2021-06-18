<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Policies Controller
 *
 * @property \App\Model\Table\PoliciesTable $Policies
 * @method \App\Model\Entity\Policy[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PoliciesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->savelog(200, "Accessed policies page", 1, 3, "", "");
        
        $policies = $this->Policies->find("all")->contain(['Companies', 'Options', 'Customers', 'Users']);

        $this->set(compact('policies'));
    }

    public function dashboard(){

    }

    /**
     * View method
     *
     * @param string|null $id Policy id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('Riders');
        

        if($this->request->is(['patch', 'put', 'post'])){
            $this->updateriders($this->request->getData()['policy_id'], $this->request->getData()['has_rider']);
        }

        $policy = $this->Policies->get($id, [
            'contain' => ['Companies', 'Options', 'Customers', 'Users', 'Payments', 'Dependants', 'PoliciesRiders' => ['Riders']],
        ]);
        $riders = $this->Riders->find("all");
        $dependant = $this->Policies->Dependants->newEmptyEntity();

        $this->set(compact('policy', 'dependant', 'riders'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($customer_id = false)
    {
        $policy = $this->Policies->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $certificate = $this->request->getData('certificate');
            $name = $certificate->getClientFilename();
            $type = $certificate->getClientMediaType();
            $targetPath = WWW_ROOT. 'img'. DS . 'certificates'. DS. $name;
            if (!empty($name)) {
                if ($certificate->getSize() > 0 && $certificate->getError() == 0) {
                    $certificate->moveTo($targetPath); 
                    $data['certificate'] = $name;
                }
            }else{
                $data['certificate'] = '';
            }
            $policy = $this->Policies->patchEntity($policy, $data);
            $policy->user_id = $this->Auth->user()['id'];
            $customer = $this->Policies->Customers->get($policy->customer_id);
            if ($this->Policies->save($policy)) {
                $this->savelog(200, "Created policy for customer: ".$customer->name, 1, 1, "", json_encode($policy));
                $this->Flash->success(__('The policy has been saved.'));
                return $this->redirect(['controller' => 'Customers', 'action' => 'edit', $policy->customer_id]);
            }
            $this->savelog(500, "Tempted to create policy for customer: ".$customer->name, 0, 1, "", json_encode($policy));
            $this->Flash->error(__('The policy could not be saved. Please, try again.'));
        }
        $companies = $this->Policies->Companies->find('list');
        $customers = $this->Policies->Customers->find('list', ['order' => ['name ASC']]);
        $this->set(compact('policy', 'companies', 'customers', 'customer_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Policy id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $policy = $this->Policies->get($id, [
            'contain' => [],
        ]);
        $old_data = json_encode($policy);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $certificate = $this->request->getData('certificate');
            $name = $certificate->getClientFilename();
            $type = $certificate->getClientMediaType();
            $targetPath = WWW_ROOT. 'img'. DS . 'certificates'. DS. $name;
            if (!empty($name)) {
                if ($certificate->getSize() > 0 && $certificate->getError() == 0) {
                    $certificate->moveTo($targetPath); 
                    $data['certificate'] = $name;
                }else{
                        $data['certificate'] = $policy->certificate;
                }
            }else{
                $data['certificate'] = $policy->certificate;
            }
            $policy = $this->Policies->patchEntity($policy, $data);
            $customer = $this->Policies->Customers->get($policy->customer_id);
            if ($this->Policies->save($policy)) {
                $this->savelog(200, "Edited policy for customer: ".$customer->name, 1, 2, $old_data, json_encode($policy));
                $this->Flash->success(__('The policy has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->savelog(500, "Tempted to edit policy for customer: ".$customer->name, 0, 2, $old_data, json_encode($policy));
            $this->Flash->error(__('The policy could not be saved. Please, try again.'));
        }
        $companies = $this->Policies->Companies->find('list', ['limit' => 200]);
        $options = $this->Policies->Options->find('list', [
            'keyField' => 'id',
            'valueField' => function ($option) {
                return $option->get('full');
            }, 
            'conditions' => array('company_id' => $policy->company_id)
        ]);
        $customers = $this->Policies->Customers->find('list', ['limit' => 200]);
        $users = $this->Policies->Users->find('list', ['limit' => 200]);
        $this->set(compact('policy', 'companies', 'options', 'customers', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Policy id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $policy = $this->Policies->get($id);
        if ($this->Policies->delete($policy)) {
            $this->Flash->success(__('The policy has been deleted.'));
        } else {
            $this->Flash->error(__('The policy could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function report(){
        // Set Dates
        $from = $this->session->read("from"); 
        $to = $this->session->read("to");
        // Get each company 
        $comps = $this->Policies->Companies->find("list");
        // loop through each company and get policies that have due for date interval
        

        if($this->request->is(['patch', 'put', 'post'])){
            if(!empty($this->request->getData()['type'])){
                if(!empty($this->request->getData()['company_id'])){
                    $companies = $this->Policies->Companies->find("all", array("conditions" => array("type" => $this->request->getData()['type'], "id" => $this->request->getData()['company_id']), "order" => array("name ASC")));
                }else{
                    $companies = $this->Policies->Companies->find("all", array("conditions" => array("type" => $this->request->getData()['type']), "order" => array("name ASC")));
                }
            }else{
                if(!empty($this->request->getData()['company_id'])){
                    $companies = $this->Policies->Companies->find("all", array("conditions" => array("company_id" => $this->request->getData()['company_id']), "order" => array("name ASC")));
                }else{
                    $companies = $this->Policies->Companies->find("all", array("order" => array("name ASC")));
                }
            }
        }else{
            $companies = $this->Policies->Companies->find("all", array("order" => array("name ASC")));
        }

        foreach($companies as $company){
            $company->policies = $this->Policies->find("all", array("conditions" => array("Policies.company_id" => $company->id, "paid_until >=" => $from, "paid_until <=" => $to), "order" => array("paid_until ASC")))->contain(['Customers', 'Options']);
        }
        // Add a filter for life or health 

        $this->set(compact("companies", 'comps'));
    }

    public function alerts(){
        
    }

    private function updateriders($policy, $riders){
        $this->loadModel('PoliciesRiders'); 
        // delete old riders
        $pr = $this->PoliciesRiders->find("all", array('conditions' => array("policy_id" => $policy))); 
        foreach($pr as $p){
            $this->PoliciesRiders->delete($p);
        }
        // create new entity for the riders and save them
        foreach($riders as $key => $rider){
            $new = $this->PoliciesRiders->newEmptyEntity();
            $new->policy_id = $policy; 
            $new->rider_id = $rider;
            $this->PoliciesRiders->save($new);
        }
    }
}
