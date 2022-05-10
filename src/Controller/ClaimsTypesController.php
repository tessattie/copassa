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
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Claims', 'Types', 'Users', 'Tenants'],
        ];
        $claimsTypes = $this->paginate($this->ClaimsTypes);

        $this->set(compact('claimsTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Claims Type id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $claimsType = $this->ClaimsTypes->get($id, [
            'contain' => ['Claims', 'Types', 'Users', 'Tenants'],
        ]);

        $this->set(compact('claimsType'));
    }

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
            $attachment = $this->request->getData('attachment');
            $name = $attachment->getClientFilename();
            $type = $attachment->getClientMediaType();
            if (!empty($name)) {
                if ($attachment->getSize() > 0 && $attachment->getError() == 0) {
                    $extension = pathinfo($name, PATHINFO_EXTENSION);
                    $targetPath = WWW_ROOT. 'img'. DS . 'claims'. DS. $claimsType->id.".".$extension;
                    $attachment->moveTo($targetPath); 
                    $data['attachment'] = $claimsType->id.".".$extension;
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
