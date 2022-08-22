<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Pendings Controller
 *
 * @property \App\Model\Table\PendingsTable $Pendings
 * @method \App\Model\Entity\Pending[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PendingsController extends AppController
{

    public function authorize(){
        if($this->Auth->user()['role_id'] == 2){

            if($this->request->getParam('action') == 'index' && ($this->authorizations[27] || $this->authorizations[28])){
                return true;
            }

            if($this->request->getParam('action') == 'add' && $this->authorizations[28]){
                return true;
            }

            if($this->request->getParam('action') == 'edit' && $this->authorizations[28]){
                return true;
            }

            if($this->request->getParam('action') == 'update' && $this->authorizations[28]){
                return true;
            }

            if($this->request->getParam('action') == 'delete' && $this->authorizations[28]){
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
        $pendings = $this->Pendings->find("all", array("conditions" => array('Pendings.tenant_id' => $this->Auth->user()['tenant_id'])))->contain(['Companies', 'Options', 'Countries', 'Users']);

        $companies = $this->Pendings->Companies->find('list', ['conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']], 'order' => ['name ASC']]);
        $options = $this->Pendings->Options->find('list', ['conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']], 'order' => ['name ASC']]);
        $countries = $this->Pendings->Countries->find('list', ['conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']], 'order' => ['name ASC']]);
        $this->set(compact('pendings', 'companies', 'options', 'countries'));
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
        $pending = $this->Pendings->newEmptyEntity();
        if ($this->request->is('post')) {
            $pending = $this->Pendings->patchEntity($pending, $this->request->getData());
            $pending->user_id = $this->Auth->user()['id'];
            $pending->status = 1;
            $pending->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Pendings->save($pending)) {
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Pending id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $pending = $this->Pendings->get($id, [
            'contain' => [],
        ]);
        if($this->Auth->user()['tenant_id'] != $pending->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pending = $this->Pendings->patchEntity($pending, $this->request->getData());
            if ($this->Pendings->save($pending)) {
                $this->Flash->success(__('The pending has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pending could not be saved. Please, try again.'));
        }
        $companies = $this->Pendings->Companies->find('list', ['limit' => 200]);
        $options = $this->Pendings->Options->find('list', ['limit' => 200]);
        $countries = $this->Pendings->Countries->find('list', ['limit' => 200]);
        $users = $this->Pendings->Users->find('list', ['limit' => 200]);
        $this->set(compact('pending', 'companies', 'options', 'countries', 'users'));
    }


    /**
     * Update method
     *
     * @param string|null $id Pending id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function update($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pending = $this->Pendings->get($this->request->getData()['pending_id'], [
                'contain' => [],
            ]);
            if($this->Auth->user()['tenant_id'] != $pending->tenant_id){
                return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
            }
            $pending->status = $this->request->getData()['status'];
            $pending->last_contact_date = $this->request->getData()['last_contact_date'];
            if ($this->Pendings->save($pending)) {
                $this->Flash->success(__('PNB updated for '.$pending->name));
            }else{
                $this->Flash->error(__('PNB could not be saved. Please contact administrator'));
            }
            
        }
        return $this->redirect(['action' => 'dashboard', 'controller' => 'policies']);
    }


    /**
     * Delete method
     *
     * @param string|null $id Pending id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $this->request->allowMethod(['post', 'delete', 'get']);
        $pending = $this->Pendings->get($id);
        if($this->Auth->user()['tenant_id'] != $pending->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        if ($this->Pendings->delete($pending)) {
            $this->Flash->success(__('The pending new business has been deleted.'));
        } else {
            $this->Flash->error(__('The pending new business could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
