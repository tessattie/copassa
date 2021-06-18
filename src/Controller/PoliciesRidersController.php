<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PoliciesRiders Controller
 *
 * @property \App\Model\Table\PoliciesRidersTable $PoliciesRiders
 * @method \App\Model\Entity\PoliciesRider[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PoliciesRidersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Policies', 'Riders'],
        ];
        $policiesRiders = $this->paginate($this->PoliciesRiders);

        $this->set(compact('policiesRiders'));
    }

    /**
     * View method
     *
     * @param string|null $id Policies Rider id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $policiesRider = $this->PoliciesRiders->get($id, [
            'contain' => ['Policies', 'Riders'],
        ]);

        $this->set(compact('policiesRider'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $policiesRider = $this->PoliciesRiders->newEmptyEntity();
        if ($this->request->is('post')) {
            $policiesRider = $this->PoliciesRiders->patchEntity($policiesRider, $this->request->getData());
            if ($this->PoliciesRiders->save($policiesRider)) {
                $this->Flash->success(__('The policies rider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The policies rider could not be saved. Please, try again.'));
        }
        $policies = $this->PoliciesRiders->Policies->find('list', ['limit' => 200]);
        $riders = $this->PoliciesRiders->Riders->find('list', ['limit' => 200]);
        $this->set(compact('policiesRider', 'policies', 'riders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Policies Rider id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $policiesRider = $this->PoliciesRiders->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $policiesRider = $this->PoliciesRiders->patchEntity($policiesRider, $this->request->getData());
            if ($this->PoliciesRiders->save($policiesRider)) {
                $this->Flash->success(__('The policies rider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The policies rider could not be saved. Please, try again.'));
        }
        $policies = $this->PoliciesRiders->Policies->find('list', ['limit' => 200]);
        $riders = $this->PoliciesRiders->Riders->find('list', ['limit' => 200]);
        $this->set(compact('policiesRider', 'policies', 'riders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Policies Rider id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $policiesRider = $this->PoliciesRiders->get($id);
        if ($this->PoliciesRiders->delete($policiesRider)) {
            $this->Flash->success(__('The policies rider has been deleted.'));
        } else {
            $this->Flash->error(__('The policies rider could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
