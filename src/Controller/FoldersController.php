<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Folders Controller
 *
 * @property \App\Model\Table\FoldersTable $Folders
 *
 * @method \App\Model\Entity\Folder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FoldersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $folders = $this->Folders->find('treeList', []);

        $this->set(compact('folders'));
    }

    public function show($id = 1){
        
        $filee = $this->Folders->Files->newEmptyEntity();
        $folderr = $this->Folders->newEmptyEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            // debug($this->request->getData()); 
            // die();
                if($this->request->getData()['type'] == 1){
                    if(!empty($_FILES['location']['tmp_name'])){
                       $filee = $this->Folders->Files->patchEntity($filee, $this->request->getData());
                       
                       $filee->location = '';
                       $filee->tenant_id = $this->Auth->user()['tenant_id'];
                       $filee->user_id = $this->Auth->user()['id'];
                        if ($ident = $this->Folders->Files->save($filee)) {
                            $loca = $this->checkFile($_FILES['location'], $ident['id'], $ident['extension']);
                            $newFile = $this->Folders->Files->get($ident['id']);
                            $newFile->location = $loca;
                            $this->Folders->Files->save($newFile);
                            $this->loadModel('FoldersFiles');
                            $ff = $this->FoldersFiles->newEmptyEntity();
                            $ff->folder_id = $id;
                            $ff->file_id = $ident['id'];
                            $this->FoldersFiles->save($ff);
                        } 
                    }
                }
                if($this->request->getData()['type'] == 2){
                    $folderr = $this->Folders->patchEntity($folderr, $this->request->getData());
                    $folderr->user_id = $this->Auth->user()['id'];
                    $folderr->parent_id = $id;
                    $folderr->tenant_id = $this->Auth->user()['tenant_id'];
                    $this->Folders->save($folderr);
                }
            
        }
        if($this->Auth->user()['role_id'] == 1){
            $folders = $this->Folders->find('treeList', array("conditions" => array("Folders.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(["Users"]);
            $active_folder = $this->Folders->get($id, [
            'contain' => [
                'Files', "ChildFolders"
            ]]);
        }else{
            $folders = $this->Folders->find('treeList', array("conditions" => array("Folders.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(["Users"])->matching('Users', function(\Cake\ORM\Query $q) {
                        return $q->where(['Users.id' => $this->Auth->user()['id']]);
                    });
            // $folders = $this->completeTreeList($folders, "_");
            $active_folderr  = $this->Folders->find('all', array("conditions" => array("Folders.id" => $id, "Folders.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Files']);
        foreach($active_folderr  as $af){
            $af->child_folders = $this->Folders->find('all', array("conditions" => array("Folders.parent_id" => $af->id) ))->contain(["Users"])->matching('Users', function(\Cake\ORM\Query $q) {
                        return $q->where(['Users.id' => $this->Auth->user()['id']]);
                    });
                $active_folder  = $af;
        }

        }
            $filee = $this->Folders->Files->newEmptyEntity();
        $folderr = $this->Folders->newEmptyEntity();
        
        $breadcrumbs = $this->Folders->find('path', ['for' => $id]);

        $this->set(compact('folders', 'active_folder', 'breadcrumbs', "filee", 'folderr'));
    }

    /**
     * View method
     *
     * @param string|null $id Folder id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $folder = $this->Folders->get($id, [
            'contain' => ['ParentFolders', 'Users', 'Files', 'ChildFolders']
        ]);

        $this->set('folder', $folder);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $folder = $this->Folders->newEmptyEntity();
        if ($this->request->is('post')) {
            $folder = $this->Folders->patchEntity($folder, $this->request->getData());
            $folder->user_id = $this->Auth->user()['id'];

            if ($this->Folders->save($folder)) {
                $this->Flash->success(__('The folder has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The folder could not be saved. Please, try again.'));
        }
        $parentFolders = $this->Folders->find('treeList', []);
        $users = $this->Folders->Users->find('list', ['limit' => 200]);
        $files = $this->Folders->Files->find('list', ['limit' => 200]);
        $this->set(compact('folder', 'parentFolders', 'users', 'files'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Folder id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $folder = $this->Folders->get($id, [
            'contain' => ['Users', 'Files']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $folder = $this->Folders->patchEntity($folder, $this->request->getData());
            if ($this->Folders->save($folder)) {
                $this->Flash->success(__('The folder has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The folder could not be saved. Please, try again.'));
        }
        $parentFolders = $this->Folders->find('treeList', []);
        $users = $this->Folders->Users->find('list', ['limit' => 200]);
        $files = $this->Folders->Files->find('list', ['limit' => 200]);
        $this->set(compact('folder', 'parentFolders', 'users', 'files'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Folder id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', "get"]);
        $folder = $this->Folders->get($id, ['contain' => ['ChildFolders', "Files"]]);
        $parent_id = $folder->parent_id;
        if ($this->Folders->delete($folder)) {
            $this->Flash->success(__('The folder has been deleted.'));
        } else {
            $this->Flash->error(__('The folder could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => "show", $parent_id]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Folder id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete2($id = null)
    {
        $this->request->allowMethod(['post', 'delete', "get"]);
        $folder = $this->Folders->get($id, ['contain' => ['ChildFolders', "Files"]]);
        $parent_id = $folder->parent_id;
        if ($this->Folders->delete($folder)) {
            $this->Flash->success(__('The folder has been deleted.'));
        } else {
            $this->Flash->error(__('The folder could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => "index"]);
    }
}
