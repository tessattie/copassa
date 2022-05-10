<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Claims Controller
 *
 * @property \App\Model\Table\ClaimsTable $Claims
 * @method \App\Model\Entity\Claim[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClaimsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $claims = $this->Claims->find("all", array("order" => array("Claims.created DESC"), 'conditions' => array("Claims.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Policies' => ['Customers'], 'ClaimsTypes']);
        $this->set(compact('claims'));
    }

    /**
     * View method
     *
     * @param string|null $id Claim id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $claim = $this->Claims->get($id, [
            'contain' => ['Policies' => ['Customers'], 'Users', 'ClaimsTypes' => ['Types', 'Users', 'sort' => ['ClaimsTypes.created ASC']]],
        ]);

        $claims_types = $this->Claims->ClaimsTypes->Types->find('list', ['order' => ['name ASC'], 'conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']]]);

        $this->set(compact('claim', 'claims_types'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $claim = $this->Claims->newEmptyEntity();
        if ($this->request->is('post')) {
            $claim = $this->Claims->patchEntity($claim, $this->request->getData());
            $claim->tenant_id = $this->Auth->user()['tenant_id'];
            $claim->user_id = $this->Auth->user()['id'];
            $claim->status = 1;
            if ($this->Claims->save($claim)) {
                $this->Flash->success(__('The claim has been saved.'));

                return $this->redirect(['action' => 'view', $claim->id]);
            }
            $this->Flash->error(__('The claim could not be saved. Please, try again.'));
        }
        $customers = $this->Claims->Policies->Customers->find('list', ['order' => ['name ASC'], 'conditions' => ['Customers.tenant_id' => $this->Auth->user()['tenant_id']]]);
        $policies = [];
        $this->set(compact('claim', 'policies', 'customers'));
    }


    /**
     * Add Claim Type method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addct()
    {
        $claimsType = $this->Claims->ClaimsTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $attachment = $this->request->getData('attachment');
            $name = $attachment->getClientFilename();
            $type = $attachment->getClientMediaType();
            $targetPath = WWW_ROOT. 'img'. DS . 'claims'. DS. $claimsType->id.".".$type;
            if (!empty($name)) {
                if ($attachment->getSize() > 0 && $attachment->getError() == 0) {
                    $extension = pathinfo($name, PATHINFO_EXTENSION);
                    $targetPath = WWW_ROOT. 'img'. DS . 'claims'. DS. $claimsType->id.".".$extension;
                    $attachment->moveTo($targetPath); 
                    $data['attachment'] = $claimsType->id.".".$extension;
                }
            }else{
                $data['attachment'] = '';
            }
            $claimsType = $this->Claims->ClaimsTypes->patchEntity($claimsType, $data);
            $claimsType->tenant_id = $this->Auth->user()['tenant_id'];
            $claimsType->user_id = $this->Auth->user()['id'];

            if ($this->Claims->ClaimsTypes->save($claimsType)) {
                $this->Flash->success(__('The claims type has been saved.'));

                return $this->redirect(['action' => 'view', $claimsType->claim_id]);
            }
            $this->Flash->error(__('The new information could not be added. Please contact administrator'));
            return $this->redirect(['action' => 'view', $claim->id]);
        }
    }


    /**
     * Edit method
     *
     * @param string|null $id Claim id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $claim = $this->Claims->get($id, [
            'contain' => ['Types'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $claim = $this->Claims->patchEntity($claim, $this->request->getData());
            if ($this->Claims->save($claim)) {
                $this->Flash->success(__('The claim has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The claim could not be saved. Please, try again.'));
        }
        $policies = $this->Claims->Policies->find('list', ['limit' => 200]);
        $users = $this->Claims->Users->find('list', ['limit' => 200]);
        $tenants = $this->Claims->Tenants->find('list', ['limit' => 200]);
        $types = $this->Claims->Types->find('list', ['limit' => 200]);
        $this->set(compact('claim', 'policies', 'users', 'tenants', 'types'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Claim id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $claim = $this->Claims->get($id);
        if ($this->Claims->delete($claim)) {
            $this->Flash->success(__('The claim has been deleted.'));
        } else {
            $this->Flash->error(__('The claim could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
