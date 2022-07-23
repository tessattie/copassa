<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Countries Controller
 *
 * @property \App\Model\Table\CountriesTable $Countries
 * @method \App\Model\Entity\Country[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CountriesController extends AppController
{

    public function authorize(){
        if($this->Auth->user()['role_id'] == 2){

            if($this->request->getParam('action') == 'index' && ($this->authorizations[16] || $this->authorizations[17]  || $this->authorizations[62])){
                return true;
            }

            if($this->request->getParam('action') == 'add' && $this->authorizations[17]){
                return true;
            }

            if($this->request->getParam('action') == 'edit' && $this->authorizations[17]){
                return true;
            }

            if($this->request->getParam('action') == 'delete' && $this->authorizations[17]){
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
        $countries = $this->Countries->find("all", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id']), "order" => array("name ASC")))->contain(['Customers', 'CountriesAgents' => ['Agents']]);

        $this->set(compact('countries'));
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
        $country = $this->Countries->newEmptyEntity();
        if ($this->request->is('post')) {
            $country = $this->Countries->patchEntity($country, $this->request->getData());
            $country->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Countries->save($country)) {
                $this->Flash->success(__('The country has been saved.'));
                return $this->redirect(['action' => 'edit', $country->id]);
            }
            $this->Flash->error(__('The country could not be saved. Please, try again.'));
        }
        $this->set(compact('country'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Country id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $country = $this->Countries->get($id, [
            'contain' => ['CountriesAgents'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $country = $this->Countries->patchEntity($country, $this->request->getData());
            // debug($this->request->getData());die();
            if ($this->Countries->save($country)) {
                $this->Flash->success(__('The country has been saved.'));
                if(!empty($this->request->getData()['agents'])){
                    $this->loadModel('CountriesAgents');
                $all =  $this->CountriesAgents->find("all", array("conditions" => array('country_id' => $country->id)));
                foreach($all as $delete){
                    $this->CountriesAgents->delete($delete);
                }
                foreach($this->request->getData()['agents']['_ids'] as $key => $id){
                    if($id != 0){
                        $this->saveCA($country->id, $id);
                    }
                    
                }
                }
                
                return $this->redirect(['action' => 'edit', $country->id]);
            }
            $this->Flash->error(__('The country could not be saved. Please, try again.'));
        }
        $this->loadModel("Agents");
        $agents = $this->Agents->find('all', ['order' => ['name ASC'], 'conditions' => ["Agents.tenant_id" => $this->Auth->user()['tenant_id']]]);
        $this->set(compact('country', 'agents'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Country id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $this->request->allowMethod(['post', 'delete', 'get']);
        $country = $this->Countries->get($id);
        if ($this->Countries->delete($country)) {
            $this->Flash->success(__('The country has been deleted.'));
        } else {
            $this->Flash->error(__('The country could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
