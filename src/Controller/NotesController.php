<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Notes Controller
 *
 * @property \App\Model\Table\NotesTable $Notes
 * @method \App\Model\Entity\Note[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotesController extends AppController
{

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $note = $this->Notes->newEmptyEntity();
        if ($this->request->is('post')) {
            $note = $this->Notes->patchEntity($note, $this->request->getData());
            $note->user_id = $this->Auth->user()['id']; 
            if ($this->Notes->save($note)) {
                return $this->redirect(['controller' => 'customers', 'action' => 'view', $note->customer_id]);
            }
            $this->Flash->error(__('The note could not be saved. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }


    /**
     * Delete method
     *
     * @param string|null $id Note id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);

        $note = $this->Notes->get($id);
        $customer_id = $note->customer_id;

        $this->Notes->delete($note);

        return $this->redirect(['controller' => 'customers', 'action' => 'view', $customer_id]);
    }
}
