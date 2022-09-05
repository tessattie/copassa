<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Folders Controller
 *
 * @property \App\Model\Table\FoldersTable $Folders
 * @method \App\Model\Entity\Folder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FoldersController extends AppController
{

    public function authorize(){
        if($this->Auth->user()['role_id'] == 2){

            if($this->request->getParam('action') == 'index' && ($this->authorizations[43] || $this->authorizations[44])){
                return true;
            }

            if($this->request->getParam('action') == 'add' && $this->authorizations[44]){
                return true;
            }

            if($this->request->getParam('action') == 'edit' && $this->authorizations[44]){
                return true;
            }

            if($this->request->getParam('action') == 'delete' && $this->authorizations[44]){
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
        $folders = $this->Folders->find("all", array("conditions" => array("Folders.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Files']);

        $this->set(compact('folders'));
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
        $folder = $this->Folders->newEmptyEntity();
        if ($this->request->is('post')) {
            $folder = $this->Folders->patchEntity($folder, $this->request->getData());
            $folder->tenant_id = $this->Auth->user()['tenant_id'];
            $folder->user_id = $this->Auth->user()['id'];
            $this->Folders->save($folder);
                
        }
        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string|null $id Folder id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $folder = $this->Folders->get($id, [
            'contain' => ['Files'],
        ]);

        if($this->Auth->user()['tenant_id'] != $folder->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $folder = $this->Folders->patchEntity($folder, $this->request->getData());
            if ($this->Folders->save($folder)) {

                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact('folder'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Folder id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        $this->request->allowMethod(['post', 'delete', 'get']);
        $folder = $this->Folders->get($id);

        if($this->Auth->user()['tenant_id'] != $folder->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        if ($this->Folders->delete($folder)) {
            $this->Flash->success(__('The folder has been deleted.'));
        } else {
            $this->Flash->error(__('The folder could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
