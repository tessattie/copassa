<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CountriesAgents Controller
 *
 * @property \App\Model\Table\CountriesAgentsTable $CountriesAgents
 * @method \App\Model\Entity\CountriesAgent[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CountriesAgentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Countries', 'Agents'],
        ];
        $countriesAgents = $this->paginate($this->CountriesAgents);

        $this->set(compact('countriesAgents'));
    }

    /**
     * View method
     *
     * @param string|null $id Countries Agent id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $countriesAgent = $this->CountriesAgents->get($id, [
            'contain' => ['Countries', 'Agents'],
        ]);

        $this->set(compact('countriesAgent'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $countriesAgent = $this->CountriesAgents->newEmptyEntity();
        if ($this->request->is('post')) {
            $countriesAgent = $this->CountriesAgents->patchEntity($countriesAgent, $this->request->getData());
            if ($this->CountriesAgents->save($countriesAgent)) {
                $this->Flash->success(__('The countries agent has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The countries agent could not be saved. Please, try again.'));
        }
        $countries = $this->CountriesAgents->Countries->find('list', ['limit' => 200]);
        $agents = $this->CountriesAgents->Agents->find('list', ['limit' => 200]);
        $this->set(compact('countriesAgent', 'countries', 'agents'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Countries Agent id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $countriesAgent = $this->CountriesAgents->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $countriesAgent = $this->CountriesAgents->patchEntity($countriesAgent, $this->request->getData());
            if ($this->CountriesAgents->save($countriesAgent)) {
                $this->Flash->success(__('The countries agent has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The countries agent could not be saved. Please, try again.'));
        }
        $countries = $this->CountriesAgents->Countries->find('list', ['limit' => 200]);
        $agents = $this->CountriesAgents->Agents->find('list', ['limit' => 200]);
        $this->set(compact('countriesAgent', 'countries', 'agents'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Countries Agent id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $countriesAgent = $this->CountriesAgents->get($id);
        if ($this->CountriesAgents->delete($countriesAgent)) {
            $this->Flash->success(__('The countries agent has been deleted.'));
        } else {
            $this->Flash->error(__('The countries agent could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
