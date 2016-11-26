<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Buses Controller
 *
 * @property \App\Model\Table\BusesTable $Buses
 */
class BusesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $buses = $this->paginate($this->Buses);

        $this->set(compact('buses'));
        $this->set('_serialize', ['buses']);
    }

    /**
     * View method
     *
     * @param string|null $id Bus id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bus = $this->Buses->get($id, [
            'contain' => []
        ]);

        $this->set('bus', $bus);
        $this->set('_serialize', ['bus']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bus = $this->Buses->newEntity();
        if ($this->request->is('post')) {
            $bus = $this->Buses->patchEntity($bus, $this->request->data);
            if ($this->Buses->save($bus)) {
                $this->Flash->success(__('The bus has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bus could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('bus'));
        $this->set('_serialize', ['bus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Bus id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bus = $this->Buses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bus = $this->Buses->patchEntity($bus, $this->request->data);
            if ($this->Buses->save($bus)) {
                $this->Flash->success(__('The bus has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bus could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('bus'));
        $this->set('_serialize', ['bus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Bus id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bus = $this->Buses->get($id);
        if ($this->Buses->delete($bus)) {
            $this->Flash->success(__('The bus has been deleted.'));
        } else {
            $this->Flash->error(__('The bus could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
