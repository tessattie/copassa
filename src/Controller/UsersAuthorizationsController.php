<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * UsersAuthorizations Controller
 *
 * @property \App\Model\Table\UsersAuthorizationsTable $UsersAuthorizations
 * @method \App\Model\Entity\UsersAuthorization[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersAuthorizationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Authorizations'],
        ];
        $usersAuthorizations = $this->paginate($this->UsersAuthorizations);

        $this->set(compact('usersAuthorizations'));
    }

    /**
     * View method
     *
     * @param string|null $id Users Authorization id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usersAuthorization = $this->UsersAuthorizations->get($id, [
            'contain' => ['Users', 'Authorizations'],
        ]);

        $this->set(compact('usersAuthorization'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usersAuthorization = $this->UsersAuthorizations->newEmptyEntity();
        if ($this->request->is('post')) {
            $usersAuthorization = $this->UsersAuthorizations->patchEntity($usersAuthorization, $this->request->getData());
            if ($this->UsersAuthorizations->save($usersAuthorization)) {
                $this->Flash->success(__('The users authorization has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users authorization could not be saved. Please, try again.'));
        }
        $users = $this->UsersAuthorizations->Users->find('list', ['limit' => 200]);
        $authorizations = $this->UsersAuthorizations->Authorizations->find('list', ['limit' => 200]);
        $this->set(compact('usersAuthorization', 'users', 'authorizations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Users Authorization id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usersAuthorization = $this->UsersAuthorizations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usersAuthorization = $this->UsersAuthorizations->patchEntity($usersAuthorization, $this->request->getData());
            if ($this->UsersAuthorizations->save($usersAuthorization)) {
                $this->Flash->success(__('The users authorization has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users authorization could not be saved. Please, try again.'));
        }
        $users = $this->UsersAuthorizations->Users->find('list', ['limit' => 200]);
        $authorizations = $this->UsersAuthorizations->Authorizations->find('list', ['limit' => 200]);
        $this->set(compact('usersAuthorization', 'users', 'authorizations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Users Authorization id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usersAuthorization = $this->UsersAuthorizations->get($id);
        if ($this->UsersAuthorizations->delete($usersAuthorization)) {
            $this->Flash->success(__('The users authorization has been deleted.'));
        } else {
            $this->Flash->error(__('The users authorization could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
