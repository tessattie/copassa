<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Agents Controller
 *
 * @property \App\Model\Table\AgentsTable $Agents
 * @method \App\Model\Entity\Agent[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AgentsController extends AppController
{

    public function authorize(){
        if($this->Auth->user()['role_id'] == 2){

            if($this->request->getParam('action') == 'index' && ($this->authorizations[59] || $this->authorizations[60]  || $this->authorizations[62])){
                return true;
            }

            if($this->request->getParam('action') == 'add' && $this->authorizations[60]){
                return true;
            }

            if($this->request->getParam('action') == 'edit' && $this->authorizations[60]){
                return true;
            }

            if($this->request->getParam('action') == 'delete' && $this->authorizations[60]){
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
        $agents = $this->Agents->find("all", array("order" => array("Agents.name ASC"), "conditions" => array("Agents.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['CountriesAgents' => ['Countries'], 'Customers']);

        $this->set(compact('agents'));
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
        $agent = $this->Agents->newEmptyEntity();
        if ($this->request->is('post')) {
            $agent = $this->Agents->patchEntity($agent, $this->request->getData());
            $agent->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Agents->save($agent)) {
                $this->Flash->success(__('The agent has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The agent could not be saved. Please, try again.'));
        }
        $this->set(compact('agent'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Agent id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        $agent = $this->Agents->get($id, [
            'contain' => ['CountriesAgents'],
        ]);

        if($this->Auth->user()['tenant_id'] != $agent->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            // debug($this->request->getData()); die();
            $agent = $this->Agents->patchEntity($agent, $this->request->getData());
            if ($this->Agents->save($agent)) {
                $this->loadModel('CountriesAgents');
                $all =  $this->CountriesAgents->find("all", array("conditions" => array('agent_id' => $agent->id)));
                foreach($all as $delete){
                    $this->CountriesAgents->delete($delete);
                }
                if(!empty($this->request->getData()['countries'])){
                    foreach($this->request->getData()['countries']['_ids'] as $key => $id){
                        if($id != 0){
                            $this->saveCA($id, $agent->id);
                        }
                    }
                }
                
                $this->Flash->success(__('The agent has been saved.'));

                return $this->redirect(['action' => 'edit', $agent->id]);
            }
            $this->Flash->error(__('The agent could not be saved. Please, try again.'));
        }
        $this->loadModel("Countries");
        $countries = $this->Countries->find('all', ['order' => ['name ASC'], 'conditions' => ["Countries.tenant_id" => $this->Auth->user()['tenant_id']]]);
        $this->set(compact('agent', 'countries'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Agent id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $this->request->allowMethod(['post', 'delete', 'get']);
        $agent = $this->Agents->get($id);

        if($this->Auth->user()['tenant_id'] != $agent->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        
        if ($this->Agents->delete($agent)) {
            $this->Flash->success(__('The agent has been deleted.'));
        } else {
            $this->Flash->error(__('The agent could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function list(){
        if($this->request->is(['ajax'])){
            $country_id = $this->request->getData()['country_id'];
            $agents = $this->Agents->find("all", array("order" => array("name ASC"), "conditions" => array("Agents.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['CountriesAgents']);
            $result = [];
            foreach($agents as $agent){
                foreach($agent->countries_agents as $ca){
                    if($ca->country_id == $country_id){
                        array_push($result, $agent);
                    }
                }
            }
            echo json_encode($result);
        }
        die();
    }
}
