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
    public function authorize(){
        if($this->Auth->user()['role_id'] == 2){
            return false;
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
    public function index($id = false)
    {
        
        $user_authorizations = [];

        $authorizations = [];

        $users = $this->Authorizations->UsersAuthorizations->Users->find("all", array("order" => array("name ASC"), "conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'], 'role_id' => 2 )));


        if($id){
            $this->loadModel("UsersAuthorizations");
            if($this->plan == 1){
                $authorizations = $this->Authorizations->find("all", array("order" => array("type ASC"), "conditions" => array("id !=8 AND id != 9", 'OR' => array("type = 1", "type = 2", "type = 3", "type = 4", "type = 5", "type = 6", "type = 7"))));
            }

            if($this->plan == 2){
                $authorizations = $this->Authorizations->find("all", array("order" => array("type ASC"), "conditions" => array('OR' => array("type = 1", "type = 2", "type = 3", "type = 4", "type = 5", "type = 6", "type = 7", "type = 13"))));
            }

            if($this->plan == 3){
                $authorizations = $this->Authorizations->find("all", array("order" => array("type ASC"), "conditions" => array('OR' => array("type = 1", "type = 2", "type = 3", "type = 4", "type = 5", "type = 6", "type = 7", "type = 13", "type = 10"))));
            }

            if($this->plan == 4){
                $authorizations = $this->Authorizations->find("all", array("order" => array("type ASC")));
            } 
        }

        
        
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
}
