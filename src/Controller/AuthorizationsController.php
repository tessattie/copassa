<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Authorizations Controller
 *
 * @property \App\Model\Table\AuthorizationsTable $Authorizations
 * @method \App\Model\Entity\Authorization[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AuthorizationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = false)
    {
        $authorizations = $this->Authorizations->find("all", array("order" => array("type ASC")));
        $user_authorizations = [];
        $users = $this->Authorizations->Users->find("all", array("order" => array("name ASC"), "conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'], 'role_id' => 2 )));
        if($id){
            $this->loadModel("UsersAuthorizations");
            $user_authorizations = $this->UsersAuthorizations->find("all", array("conditions" => array("user_id" => $id)));
        }
        $user_id = $id;
        $this->set(compact('authorizations', 'users', 'user_authorizations', 'user_id'));
    }

    public function update(){
        if($this->request->is(['ajax'])){
            $this->loadModel("UsersAuthorizations");
            $ua = $this->UsersAuthorizations->find("all", array("conditions" => array("user_id" => $this->request->getData()['user_id'], "authorization_id" => $this->request->getData()['authorization_id'])));
            if($this->request->getData()['checked'] == 'true'){
                if($ua->count() == 0){
                    $new_ua = $this->UsersAuthorizations->newEmptyEntity();
                    $new_ua->authorization_id = $this->request->getData()['authorization_id'];
                    $new_ua->user_id =$this->request->getData()['user_id'];
                    $this->UsersAuthorizations->save($new_ua);
                }
            }else{

               if($ua->count() > 0){
                foreach($ua as $usra){
                    $this->UsersAuthorizations->delete($usra);
                }
               } 
            }
            echo json_encode($this->request->getData());
        }
        die();
    }

    /**
     * View method
     *
     * @param string|null $id Authorization id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $authorization = $this->Authorizations->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('authorization'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $authorization = $this->Authorizations->newEmptyEntity();
        if ($this->request->is('post')) {
            $authorization = $this->Authorizations->patchEntity($authorization, $this->request->getData());
            if ($this->Authorizations->save($authorization)) {
                $this->Flash->success(__('The authorization has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The authorization could not be saved. Please, try again.'));
        }
        $users = $this->Authorizations->Users->find('list', ['limit' => 200]);
        $this->set(compact('authorization', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Authorization id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $authorization = $this->Authorizations->get($id, [
            'contain' => ['Users'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $authorization = $this->Authorizations->patchEntity($authorization, $this->request->getData());
            if ($this->Authorizations->save($authorization)) {
                $this->Flash->success(__('The authorization has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The authorization could not be saved. Please, try again.'));
        }
        $users = $this->Authorizations->Users->find('list', ['limit' => 200]);
        $this->set(compact('authorization', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Authorization id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $authorization = $this->Authorizations->get($id);
        if ($this->Authorizations->delete($authorization)) {
            $this->Flash->success(__('The authorization has been deleted.'));
        } else {
            $this->Flash->error(__('The authorization could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
