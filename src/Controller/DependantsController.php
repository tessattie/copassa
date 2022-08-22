<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Dependants Controller
 *
 * @property \App\Model\Table\DependantsTable $Dependants
 * @method \App\Model\Entity\Dependant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DependantsController extends AppController
{
    public function authorize(){
        if($this->Auth->user()['role_id'] == 2){

            if($this->request->getParam('action') == 'add' && $this->authorizations[24]){
                return true;
            }

            if($this->request->getParam('action') == 'edit' && $this->authorizations[24]){
                return true;
            }

            if($this->request->getParam('action') == 'delete' && $this->authorizations[24]){
                return true;
            }

            return false;

        }else{

            return true;

        }
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
        $dependant = $this->Dependants->newEmptyEntity();
        if ($this->request->is('post')) {
            $dependant = $this->Dependants->patchEntity($dependant, $this->request->getData());
            $dependant->user_id = $this->Auth->user()['id'];
            $dependant->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Dependants->save($dependant)) {
                $this->Flash->success(__('The dependant has been saved.'));
            }else{
               $this->Flash->error(__('The dependant / benificiary could not be saved. Please, try again.')); 
            }
        }
        return $this->redirect(['controller' => 'policies', 'action' => 'view', $dependant->policy_id]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Dependant id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $dependant = $this->Dependants->get($id, [
            'contain' => [],
        ]);

        if($this->Auth->user()['tenant_id'] != $dependant->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dependant = $this->Dependants->patchEntity($dependant, $this->request->getData());
            if ($this->Dependants->save($dependant)) {
                $this->Flash->success(__('The dependant has been saved.'));

                return $this->redirect(['controller' => 'policies', 'action' => 'view', $dependant->policy_id]);
            }
            $this->Flash->error(__('The dependant could not be saved. Please, try again.'));
        }
        $this->set(compact('dependant'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dependant id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $this->request->allowMethod(['post', 'delete', 'get']);
        $dependant = $this->Dependants->get($id);

        if($this->Auth->user()['tenant_id'] != $dependant->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        $policy_id = $dependant->policy_id;
        if ($this->Dependants->delete($dependant)) {
            $this->Flash->success(__('The dependant has been deleted.'));
        } else {
            $this->Flash->error(__('The dependant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'policies', 'action' => 'view', $policy_id]);
    }


    public function list(){
        if($this->request->is(['ajax'])){
            $dependants = $this->Dependants->find("all", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'], "policy_id" => $this->request->getData()['policy_id'])));
            echo json_encode($dependants->toArray()); 
        }
        die();
    }
}
