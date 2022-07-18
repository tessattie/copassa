<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Elements Controller
 *
 * @property \App\Model\Table\ElementsTable $Elements
 * @method \App\Model\Entity\Element[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ElementsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories'],
        ];
        $elements = $this->paginate($this->Elements);

        $this->set(compact('elements'));
    }

    /**
     * View method
     *
     * @param string|null $id Element id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $element = $this->Elements->get($id, [
            'contain' => ['Categories'],
        ]);

        $this->set(compact('element'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $element = $this->Elements->newEmptyEntity();
        if ($this->request->is('post')) {
            $element = $this->Elements->patchEntity($element, $this->request->getData());
            if ($this->Elements->save($element)) {
                $this->Flash->success(__('The element has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The element could not be saved. Please, try again.'));
        }
        $categories = $this->Elements->Categories->find('list', ['limit' => 200]);
        $this->set(compact('element', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Element id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $element = $this->Elements->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $element = $this->Elements->patchEntity($element, $this->request->getData());
            if ($this->Elements->save($element)) {
                $this->Flash->success(__('The element has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The element could not be saved. Please, try again.'));
        }
        $categories = $this->Elements->Categories->find('list', ['limit' => 200]);
        $this->set(compact('element', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Element id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $element = $this->Elements->get($id);
        if ($this->Elements->delete($element)) {
            $this->Flash->success(__('The element has been deleted.'));
        } else {
            $this->Flash->error(__('The element could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
