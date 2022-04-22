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
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $pendings = $this->Pendings->find("all", array("conditions" => array('Pendings.tenant_id' => $this->Auth->user()['tenant_id'])))->contain(['Companies', 'Options', 'Countries', 'Users']);

        $companies = $this->Pendings->Companies->find('list', ['conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']], 'order' => ['name ASC']]);
        $options = $this->Pendings->Options->find('list', ['conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']], 'order' => ['name ASC']]);
        $countries = $this->Pendings->Countries->find('list', ['conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']], 'order' => ['name ASC']]);
        $this->set(compact('pendings', 'companies', 'options', 'countries'));
    }

    /**
     * View method
     *
     * @param string|null $id Pending id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pending = $this->Pendings->get($id, [
            'contain' => ['Companies', 'Options', 'Countries', 'Users'],
        ]);

        $this->set(compact('pending'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
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
        $pending = $this->Pendings->get($id, [
            'contain' => [],
        ]);
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
     * Delete method
     *
     * @param string|null $id Pending id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pending = $this->Pendings->get($id);
        if ($this->Pendings->delete($pending)) {
            $this->Flash->success(__('The pending has been deleted.'));
        } else {
            $this->Flash->error(__('The pending could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
