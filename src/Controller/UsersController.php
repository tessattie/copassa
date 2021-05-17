<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->savelog(200, "Accessed users page", 1, 3, "", "");
        $users = $this->Users->find("all")->contain(['Roles']);
        $this->set(compact('users'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->savelog(200, "Created user", 1, 1, "", json_encode($user));
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }else{
                $this->savelog(500, "Tempted to create new user", 0, 1, "", json_encode($user));
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
    }


    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        $old_data = json_encode($user);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                $this->savelog(200, "Edited user", 1, 2, $old_data, json_encode($user));
                return $this->redirect(['action' => 'index']);
            }
            $this->savelog(500, "Tempted to edit user", 0, 2, $old_data, json_encode($user));
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
    }


    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function login(){
        $this->viewBuilder()->setLayout('login');
        if($this->request->is('post')){
            $user = $this->Auth->identify();
            if ($user) {
                if($user['status'] == false){
                    $this->savelog(500, "Blocked user attempted to log in", 0, 4, "", json_encode($user));
                    $this->Flash->error(__('This account is blocked. Contact your administrator'));
                }else{
                    if($user['role_id'] == 1 || $user['role_id'] == 2){
                        $this->Auth->setUser($user);
                        $this->savelog(200, "User logged in", 1, 4, "", json_encode($user));
                        return $this->redirect($this->Auth->redirectUrl());
                    }else{
                        $this->Flash->error(__('You do not have access to this application. Contact your administrator'));
                    }
                }
            }else{
                $this->savelog(500, "Unknown user attempted to logged in", 0, 4, "", json_encode($this->request->getData()));
                $this->Flash->error(__('Wrong username or password'));
            }
        }
    }

    public function logout(){
        return $this->redirect($this->Auth->logout());
    }


    public function report(){
        
    }
}
