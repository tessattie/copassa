<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Dependants Controller
 *
 * @property \App\Model\Table\DependantsTable $Dependants
 * @method \App\Model\Entity\Dependant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DependantsController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dependant = $this->Dependants->newEmptyEntity();
        if ($this->request->is('post')) {
            $dependant = $this->Dependants->patchEntity($dependant, $this->request->getData());
            $dependant->user_id = $this->Auth->user()['id'];
            if ($this->Dependants->save($dependant)) {
                $this->Flash->success(__('The dependant has been saved.'));
            }else{
               $this->Flash->error(__('The dependant / benificiary could not be saved. Please, try again.')); 
            }
        }
        return $this->redirect(['controller' => 'policies', 'action' => 'view', $dependant->policy_id]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Dependant id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dependant = $this->Dependants->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dependant = $this->Dependants->patchEntity($dependant, $this->request->getData());
            if ($this->Dependants->save($dependant)) {
                $this->Flash->success(__('The dependant has been saved.'));

                return $this->redirect(['controller' => 'policies', 'action' => 'view', $dependant->policy_id]);
            }
            $this->Flash->error(__('The dependant could not be saved. Please, try again.'));
        }
        $this->set(compact('dependant'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dependant id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $dependant = $this->Dependants->get($id);
        $policy_id = $dependant->policy_id;
        if ($this->Dependants->delete($dependant)) {
            $this->Flash->success(__('The dependant has been deleted.'));
        } else {
            $this->Flash->error(__('The dependant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'policies', 'action' => 'view', $policy_id]);
    }
}
