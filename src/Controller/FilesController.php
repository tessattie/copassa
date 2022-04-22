<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Files Controller
 *
 * @property \App\Model\Table\FilesTable $Files
 *
 * @method \App\Model\Entity\File[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'], 
        ];
        $files = $this->Files->find("all", array('order' => array('Files.created DESC')))->contain(['Users']);

        $this->set(compact('files'));
    }

    /**
     * View method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $file = $this->Files->get($id, [
            'contain' => ['Users', 'Folders']
        ]);

        $this->set('file', $file);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $file = $this->Files->newEmptyEntity();
        if ($this->request->is('post')) {
            // debug($this->request->getData());
            if(!empty($this->request->getData()['location']['tmp_name'])){
               $file = $this->Files->patchEntity($file, $this->request->getData());
               $file->location = '';
               $file->user_id = $this->Auth->user()['id'];
                if ($id = $this->Files->save($file)) {
                    $loca = $this->checkFile($this->request->getData()['location'], $id['id'], $id['extension']);
                    $newFile = $this->Files->get($id['id']);
                    $newFile->location = $loca;
                    $this->Files->save($newFile);
                    $this->Flash->success(__('The file has been saved.'));

                    return $this->redirect(['action' => 'index']);
                } 
            }
            $this->Flash->error(__('The file could not be saved. Please, try again.'));
        }
        $users = $this->Files->Users->find('list', ['limit' => 200]);
        $folders = $this->Files->Folders->find('treeList', []);
        $this->set(compact('file', 'users', 'folders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $file = $this->Files->get($id, [
            'contain' => ['Folders']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            if(empty($this->request->getData()['location']['tmp_name'])){
                unset($this->request->getData()['location']);
            }

            $file = $this->Files->patchEntity($file, $this->request->getData());

            if(!empty($this->request->getData()['location']['tmp_name'])){
                $loca = $this->checkFile($this->request->getData()['location'], $file->id, $file->extension);
                $file->location = $loca;
            }
                       
            if ($id = $this->Files->save($file)) {
                $this->Flash->success(__('The file has been saved.'));

                return $this->redirect(['action' => 'index']);
            } 
            
            $this->Flash->error(__('The file could not be saved. Please, try again.'));
        }
        $users = $this->Files->Users->find('list', ['limit' => 200]);
        $folders = $this->Files->Folders->find('treeList', []);
        $this->set(compact('file', 'users', 'folders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $folder)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $file = $this->Files->get($id);
        if ($this->Files->delete($file)) {
            $this->Flash->success(__('The file has been deleted.'));
        } else {
            $this->Flash->error(__('The file could not be deleted. Please, try again.'));
        }
            return $this->redirect(["controller" => "folders", 'action' => "show", $folder]);
    }

    /**
     * Delete method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete2($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $file = $this->Files->get($id);
        if ($this->Files->delete($file)) {
            $this->Flash->success(__('The file has been deleted.'));
        } else {
            $this->Flash->error(__('The file could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
