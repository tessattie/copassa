<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ClaimsTypes Controller
 *
 * @property \App\Model\Table\ClaimsTypesTable $ClaimsTypes
 * @method \App\Model\Entity\ClaimsType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClaimsTypesController extends AppController
{

    /**
     * Edit method
     *
     * @param string|null $id Claims Type id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('ClaimsTypes');
        $claimsType = $this->ClaimsTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();
            $this->loadModel('Folders');
            $folder = $this->Folders->find("all", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'], 'is_claims' => 2)))->first()->id;
            $uploaded_file = $this->request->getData('attachment');
            $name = $uploaded_file->getClientFilename();
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $document_name = rand(1000,500000).".".$extension;
            $type = $uploaded_file->getClientMediaType();
            $path = $uploaded_file->getStream()->getMetadata('uri');

            if(!empty($name)){
                if ($attachment->getSize() > 0 && $attachment->getError() == 0) {
                    $data['attachment'] = $this->upload_s3_file($path, $document_name, "/claims/");
                    $file = $this->Folders->Files->newEmptyEntity(); 
                    $file->user_id = $this->Auth->user()['id']; 
                    $file->tenant_id = $this->Auth->user()['tenant_id'];
                    $file->location = $data['attachment'];
                    $file->name = $data['title'];
                    $file->folder_id = $folder;
                    $file->description = $data['description'];
                    $file->claim_id = $data['claim_id'];
                    $this->Folders->Files->save($file);
                }else{
                    $data['attachment'] = $claimsType->attachment;
                }
                
            }else{
                $data['attachment'] = $claimsType->attachment;
            }
            
            $claimsType = $this->ClaimsTypes->patchEntity($claimsType, $data);
            if ($this->ClaimsTypes->save($claimsType)) {
                $this->Flash->success(__('The claims type has been saved.'));

                return $this->redirect(['action' => 'view', 'controller' => 'Claims', $claimsType->claim_id]);
            }
        }
        $claims_types = $this->ClaimsTypes->Types->find('list', ['order' => ['name ASC'], 'conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']]]);
        $this->set(compact('claimsType', 'claims_types'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Claims Type id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {   
        $this->loadModel('ClaimsTypes');
        $this->request->allowMethod(['post', 'delete', 'get']);
        $claimsType = $this->ClaimsTypes->get($id);
        $claim_id = $claimsType->claim_id;
        if ($this->ClaimsTypes->delete($claimsType)) {
            $this->Flash->success(__('The claims type has been deleted.'));
        } else {
            $this->Flash->error(__('The claims type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'view', 'controller' => 'Claims', $claim_id]);
    }
}
