<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Prenewals Controller
 *
 * @property \App\Model\Table\PrenewalsTable $Prenewals
 * @method \App\Model\Entity\Prenewal[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PrenewalsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($policy_id = false)
    {
        $filter_country = $this->session->read("filter_country");
        if(!empty($filter_country)){
            $policies = $this->Prenewals->Policies->find("all", array("conditions" => array("Policies.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Customers', 'Companies'])->matching('Customers', function ($q) use ($filter_country) {
                return $q->where(['Customers.country_id' => $filter_country]);
            });
            
        }else{
            $policies = $this->Prenewals->Policies->find("all", array("conditions" => array("Policies.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Customers', 'Companies']);
        }
        
        if(!empty($policy_id)){
            $policy = $this->Prenewals->Policies->get($policy_id, ['contain' => ['Customers']]);
            $this->savelog(200, "Accessed renewals for policy #".$policy->policy_number, 1, 3, "", "");
            $renewals = $this->Prenewals->find("all", array('order' => array('Prenewals.renewal_date desc'), "conditions" => array('Prenewals.tenant_id' => $this->Auth->user()['tenant_id'], 'Prenewals.policy_id' => $policy_id)))->contain(['Policies' => ['Customers']]);
        }else{
            $this->savelog(200, "Accessed renewals page", 1, 3, "", "");
            $policy = '';
            $renewals = $this->Prenewals->find("all", array('order' => array('Prenewals.renewal_date desc'), "conditions" => array('Prenewals.tenant_id' => $this->Auth->user()['tenant_id'])))->contain(['Policies' => ['Customers']]);
        }

        $this->set(compact('policies', 'policy_id', 'policy', 'renewals'));
    }

    /**
     * View method
     *
     * @param string|null $id Prenewal id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $prenewal = $this->Prenewals->get($id, [
            'contain' => ['Policies'],
        ]);

        $this->set(compact('prenewal'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $prenewal = $this->Prenewals->newEmptyEntity();
        if ($this->request->is('post')) {
            $prenewal = $this->Prenewals->patchEntity($prenewal, $this->request->getData());
            $prenewal->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Prenewals->save($prenewal)) {
                $this->Flash->success(__('The prenewal has been saved.'));

                return $this->redirect(['action' => 'index', $prenewal->policy_id]);
            }
            $this->Flash->error(__('The prenewal could not be saved. Please, try again.'));
        }
        $policies = $this->Prenewals->Policies->find('list', ['order' => ['policy_number ASC']]);
        $this->set(compact('prenewal', 'policies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Prenewal id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $prenewal = $this->Prenewals->get($id, [
            'contain' => ['Policies'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $prenewal = $this->Prenewals->patchEntity($prenewal, $this->request->getData());
            if ($this->Prenewals->save($prenewal)) {
                $this->Flash->success(__('The prenewal has been saved.'));

                return $this->redirect(['action' => 'index', $prenewal->policy_id]);
            }
            $this->Flash->error(__('The prenewal could not be saved. Please, try again.'));
        }
        $policies = $this->Prenewals->Policies->find('list', ['limit' => 200]);
        $this->set(compact('prenewal', 'policies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Prenewal id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $prenewal = $this->Prenewals->get($id);
        if ($this->Prenewals->delete($prenewal)) {
            $this->Flash->success(__('The prenewal has been deleted.'));
        } else {
            $this->Flash->error(__('The prenewal could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
