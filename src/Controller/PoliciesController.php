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
        $policy = $this->Policies->get($id, [
            'contain' => ['Companies', 'Options', 'Customers', 'Users', 'Payments'],
        ]);

        $this->set(compact('policy'));
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
            if ($type == 'image/jpeg' || $type == 'image/jpg' || $type == 'image/png') {
                if (!empty($name)) {
                    if ($certificate->getSize() > 0 && $certificate->getError() == 0) {
                        $certificate->moveTo($targetPath); 
                        $data['certificate'] = $name;
                    }
                }else{
                    $data['certificate'] = '';
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
            if ($type == 'image/jpeg' || $type == 'image/jpg' || $type == 'image/png' || $type == 'application/pdf') {
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
        
    }

    public function alerts(){
        
    }
}
