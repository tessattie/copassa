<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tenants Controller
 *
 * @property \App\Model\Table\TenantsTable $Tenants
 * @method \App\Model\Entity\Tenant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TenantsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $tenants = $this->paginate($this->Tenants);

        $this->set(compact('tenants'));
    }

    /**
     * View method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tenant = $this->Tenants->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('tenant'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tenant = $this->Tenants->newEmptyEntity();
        if ($this->request->is('post')) {
            $tenant = $this->Tenants->patchEntity($tenant, $this->request->getData());
            if ($this->Tenants->save($tenant)) {
                $this->Flash->success(__('The tenant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tenant could not be saved. Please, try again.'));
        }
        $users = $this->Tenants->Users->find('list', ['limit' => 200]);
        $this->set(compact('tenant', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tenant = $this->Tenants->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tenant = $this->Tenants->patchEntity($tenant, $this->request->getData());
            if ($this->Tenants->save($tenant)) {
                $this->Flash->success(__('The tenant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tenant could not be saved. Please, try again.'));
        }
        $users = $this->Tenants->Users->find('list', ['limit' => 200]);
        $this->set(compact('tenant', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tenant = $this->Tenants->get($id);
        if ($this->Tenants->delete($tenant)) {
            $this->Flash->success(__('The tenant has been deleted.'));
        } else {
            $this->Flash->error(__('The tenant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
