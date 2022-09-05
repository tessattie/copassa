<?php
declare(strict_types=1);

namespace App\Controller;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

/**
 * Files Controller
 *
 * @property \App\Model\Table\FilesTable $Files
 * @method \App\Model\Entity\File[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesController extends AppController
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
        $files = $this->Files->find("all", array("conditions" => array("Files.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Folders', 'Policies', 'Claims']);

        $folder_id = '';

        if($this->request->is(['patch', 'put', 'post'])){
            if(!empty($this->request->getData()['folder_id'])){
                $folder_id = $this->request->getData()['folder_id'];
                $files->where(['Files.folder_id' => $folder_id]);
            }
        }
        
        $folders = $this->Files->Folders->find("list", array("order" => array('Folders.name ASC'), "conditions" => array("Folders.tenant_id" => $this->Auth->user()['tenant_id'])));

        $this->set(compact('files', 'folders', 'folder_id'));
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
        $file = $this->Files->newEmptyEntity();
        if ($this->request->is('post')) {
            
            $folder = $this->Files->Folders->get($this->request->getData()['folder_id']);
            $uploaded_file = $this->request->getData('file');
            $name = $uploaded_file->getClientFilename();
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $document_name = rand(1000,500000).".".$extension;
            $type = $uploaded_file->getClientMediaType();
            $path = $uploaded_file->getStream()->getMetadata('uri');

            $file = $this->Files->patchEntity($file, $this->request->getData());
            $file->location = $this->upload_s3_file($path, $document_name, "/".$folder->name."/");

            $file->tenant_id = $this->Auth->user()['tenant_id'];
            $file->user_id = $this->Auth->user()['id'];
            if ($this->Files->save($file)) {
                $this->Flash->success(__('The file has been saved.'));
            }
        }

        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $file = $this->Files->get($id, [
            'contain' => [],
        ]);

        if($this->Auth->user()['tenant_id'] != $file->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $file = $this->Files->patchEntity($file, $this->request->getData());
            if ($this->Files->save($file)) {
                $this->Flash->success(__('The file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The file could not be saved. Please, try again.'));
        }
        $folders = $this->Files->Folders->find('list', ['conditions' => ['Folders.tenant_id' => $this->Auth->user()['tenant_id']], 'order' => ['name ASC']]);
        $this->set(compact('file', 'folders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $this->request->allowMethod(['post', 'delete', 'get']);
        $file = $this->Files->get($id);

        if($this->Auth->user()['tenant_id'] != $file->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        
        if ($this->Files->delete($file)) {
            $this->Flash->success(__('The file has been deleted.'));
        } else {
            $this->Flash->error(__('The file could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function download(){
        $key = 'AKIARDN5TTMS72EFD65R'; 
        $secret = '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';
        $s3Client = new S3Client([
            'region' => 'us-east-1',
            'version' => '2006-03-01',
            'http'    => [
                'verify' => false     
            ],
            'credentials' => [
                'key' => $key,
                'secret' => $secret,
            ]
        ]);

        $bucket = 'arsfiles';

        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $this->request->getData()['location']
        ]);

        $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');

        // Get the actual presigned-url
        $presignedUrl = (string)$request->getUri();
        echo $presignedUrl; 
        die();
    }
}
