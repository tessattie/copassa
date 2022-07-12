<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Types Controller
 *
 * @property \App\Model\Table\TypesTable $Types
 * @method \App\Model\Entity\Type[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $types = $this->Types->find("all", array("order" => array("name ASC")))->contain(["ClaimsTypes"]);

        $this->set(compact('types'));
    }

    /**
     * View method
     *
     * @param string|null $id Type id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $type = $this->Types->get($id, [
            'contain' => ['Tenants', 'Claims'],
        ]);

        $this->set(compact('type'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $type = $this->Types->newEmptyEntity();
        if ($this->request->is('post')) {
            $types = $this->Types->find("all", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'], 'is_deductible' => 1))); 

            $type = $this->Types->patchEntity($type, $this->request->getData());
            if($types->count() == 0){
                $type->is_deductible = 1;
            }else{
                $type->is_deductible = 2;
            }
            $type->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Types->save($type)) {
                $this->Flash->success(__('The type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type could not be saved. Please, try again.'));
        }
        $this->set(compact('type'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Type id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $type = $this->Types->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $type = $this->Types->patchEntity($type, $this->request->getData());
            if ($this->Types->save($type)) {
                $this->Flash->success(__('The type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type could not be saved. Please, try again.'));
        }
        $this->set(compact('type'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Type id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $type = $this->Types->get($id);
        if ($this->Types->delete($type)) {
            $this->Flash->success(__('The type has been deleted.'));
        } else {
            $this->Flash->error(__('The type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function deductible(){
        if($this->request->is(['ajax'])){
            $types = $this->Types->find("all", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id']) )); 
            foreach($types as $type){
                if($type->id == $this->request->getData()['type_id']){
                    $type->is_deductible = 1;
                }else{
                    $type->is_deductible = 2;
                }

                $this->Types->save($type);
            }
            echo json_encode(array()); 
        }
        die();
    }
}
