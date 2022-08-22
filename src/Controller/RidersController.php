<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Riders Controller
 *
 * @property \App\Model\Table\RidersTable $Riders
 * @method \App\Model\Entity\Rider[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RidersController extends AppController
{

    public function authorize(){
        if($this->Auth->user()['role_id'] == 2){
            if($this->request->getParam('action') == 'index' && ($this->authorizations[50] || $this->authorizations[49])){
                return true;
            }

            if(($this->request->getParam('action') == 'add' || $this->request->getParam('action') == 'edit' || $this->request->getParam('action') == 'delete') && ($this->authorizations[50])){
                return true;
            }
        }else{
            return true;
        }

        return false;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        if(!$this->authorize()){
            return $this->redirect(['action' => 'authorization']);
        }
        $riders = $this->Riders->find("all", array("conditions" => array("Riders.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Users']);
        $this->set(compact('riders'));
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
        $rider = $this->Riders->newEmptyEntity();
        if ($this->request->is('post')) {
            $rider = $this->Riders->patchEntity($rider, $this->request->getData());
            $rider->user_id= $this->Auth->user()['id'];
            $rider->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Riders->save($rider)) {
                $this->Flash->success(__('The rider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rider could not be saved. Please, try again.'));
        }
        $users = $this->Riders->Users->find('list', ['limit' => 200]);
        $this->set(compact('rider', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Rider id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $rider = $this->Riders->get($id, [
            'contain' => [],
        ]);

        if($this->Auth->user()['tenant_id'] != $rider->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $rider = $this->Riders->patchEntity($rider, $this->request->getData());
            if ($this->Riders->save($rider)) {
                $this->Flash->success(__('The rider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rider could not be saved. Please, try again.'));
        }
        $this->set(compact('rider', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rider id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $this->request->allowMethod(['post', 'delete', 'get']);
        $rider = $this->Riders->get($id);

        if($this->Auth->user()['tenant_id'] != $rider->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        if ($this->Riders->delete($rider)) {
            $this->Flash->success(__('The rider has been deleted.'));
        } else {
            $this->Flash->error(__('The rider could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
