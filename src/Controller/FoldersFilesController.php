<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FoldersFiles Controller
 *
 * @property \App\Model\Table\FoldersFilesTable $FoldersFiles
 *
 * @method \App\Model\Entity\FoldersFile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FoldersFilesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Folders', 'Files']
        ];
        $foldersFiles = $this->paginate($this->FoldersFiles);

        $this->set(compact('foldersFiles'));
    }

    

    /**
     * View method
     *
     * @param string|null $id Folders File id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $foldersFile = $this->FoldersFiles->get($id, [
            'contain' => ['Folders', 'Files']
        ]);

        $this->set('foldersFile', $foldersFile);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $foldersFile = $this->FoldersFiles->newEmptyEntity();
        if ($this->request->is('post')) {
            $foldersFile = $this->FoldersFiles->patchEntity($foldersFile, $this->request->getData());
            if ($this->FoldersFiles->save($foldersFile)) {
                $this->Flash->success(__('The folders file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The folders file could not be saved. Please, try again.'));
        }
        $folders = $this->FoldersFiles->Folders->find('list', ['limit' => 200]);
        $files = $this->FoldersFiles->Files->find('list', ['limit' => 200]);
        $this->set(compact('foldersFile', 'folders', 'files'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Folders File id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $foldersFile = $this->FoldersFiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $foldersFile = $this->FoldersFiles->patchEntity($foldersFile, $this->request->getData());
            if ($this->FoldersFiles->save($foldersFile)) {
                $this->Flash->success(__('The folders file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The folders file could not be saved. Please, try again.'));
        }
        $folders = $this->FoldersFiles->Folders->find('list', ['limit' => 200]);
        $files = $this->FoldersFiles->Files->find('list', ['limit' => 200]);
        $this->set(compact('foldersFile', 'folders', 'files'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Folders File id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $foldersFile = $this->FoldersFiles->get($id);
        if ($this->FoldersFiles->delete($foldersFile)) {
            $this->Flash->success(__('The folders file has been deleted.'));
        } else {
            $this->Flash->error(__('The folders file could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
