<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Options Controller
 *
 * @property \App\Model\Table\OptionsTable $Options
 * @method \App\Model\Entity\Option[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OptionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->savelog(200, "Accessed options page", 1, 3, "", "");
        $companies = $this->Options->Companies->find('all', array("conditions" => array("Companies.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Users', 'Options' => ['Users']]);

        $this->set(compact('companies'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $option = $this->Options->newEmptyEntity();
        if ($this->request->is('post')) {
            $option = $this->Options->patchEntity($option, $this->request->getData());
            $company = $this->Options->Companies->get($this->request->getData()['company_id']);
            $option->user_id = $this->Auth->user()['id'];
            $option->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Options->save($option)) {
                $this->savelog(200, "Created option for company : ". $company->name, 1, 1, "", json_encode($option));
                $this->Flash->success(__('The option has been saved.'));
                return $this->redirect(['controller' => 'Companies', 'action' => 'edit', $option->company_id]);
            }
            $this->savelog(500, "Tempted to create option for company : ".$company->name, 0, 1, "", json_encode($option));
            $this->Flash->error(__('The option could not be saved. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Companies', 'action' => 'index']);        
    }

    /**
     * Edit method
     *
     * @param string|null $id Option id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $option = $this->Options->get($id, [
            'contain' => ['Companies'],
        ]);
        $old_data = json_encode($option);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $option = $this->Options->patchEntity($option, $this->request->getData());
            $company = $this->Options->Companies->get($option->company_id); 
            if ($this->Options->save($option)){
                $this->Flash->success(__('The option has been saved.'));
                $this->savelog(200, "Edited option for company : ".$company->name, 1, 2, $old_data, json_encode($option));
                return $this->redirect(['controller' => 'Companies', 'action' => 'edit', $option->company_id]);
            }
            $this->Flash->error(__('The option could not be saved. Please, try again.'));
            $this->savelog(500, "Tempted to edit option for company : ".$company->name, 0, 2, $old_data, json_encode($option));
            return $this->redirect(['controller' => 'Companies', 'action' => 'edit', $option->company_id]);
        }
        $this->set(compact('option'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Option id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $option = $this->Options->get($id);
        $company_id = $option->company_id;
        if ($this->Options->delete($option)) {
            $this->Flash->success(__('The option has been deleted.'));
        } else {
            $this->Flash->error(__('The option could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Companies', 'action' => 'edit', $company_id]);
    }
}
