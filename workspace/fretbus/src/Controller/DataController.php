<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Data Controller
 *
 * @property \App\Model\Table\DataTable $Data
 */
class DataController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Buses']
        ];
        $data = $this->paginate($this->Data);

        $this->set(compact('data'));
        $this->set('_serialize', ['data']);
    }

    /**
     * View method
     *
     * @param string|null $id Data id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $data = $this->Data->get($id, [
            'contain' => ['Buses']
        ]);

        $this->set('data', $data);
        $this->set('_serialize', ['data']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $data = $this->Data->newEntity();
        if ($this->request->is('post')) {
            $data = $this->Data->patchEntity($data, $this->request->data);
            if ($this->Data->save($data)) {
                $this->Flash->success(__('The data has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The data could not be saved. Please, try again.'));
            }
        }
        $buses = $this->Data->Buses->find('list', ['limit' => 200]);
        $this->set(compact('data', 'buses'));
        $this->set('_serialize', ['data']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Data id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $data = $this->Data->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->Data->patchEntity($data, $this->request->data);
            if ($this->Data->save($data)) {
                $this->Flash->success(__('The data has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The data could not be saved. Please, try again.'));
            }
        }
        $buses = $this->Data->Buses->find('list', ['limit' => 200]);
        $this->set(compact('data', 'buses'));
        $this->set('_serialize', ['data']);
    }
    
    /**
     * Método de atualização da posição do veículo.
     * O método atualiza a posição do veículo em Data e acrescenta a posição em Log
     * Log -> Histórico
     * Data -> Real
     */
     
    public function simulate(){
        $this->viewBuilder()->layout('simulate');
        $this->loadModel('Log'); //Carrega a tabela Log no sistema Data
        $simulacoes = $this->Log->find("all")->where(["vel >" => 0]);
        foreach ($simulacoes as $simulacao){
            $url =  "https://fretbus-rpissardo.c9users.io/fretbus/data/newpos/1/".$simulacao["lat"]."/".$simulacao["lon"]."/".$simulacao["vel"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            sleep (3);
            
        }
        
        
        exit;
        //$this->set(compact('dados'));
    } 
     
     public function newpos($bus_id, $lat, $lon, $vel)
    {
        //if($lat!='0.0'){
        $this->loadModel('Log'); //Carrega a tabela Log no sistema Data
        $log = $this->Log->newEntity();//Cria uma nova entidade
        $logarray = ['bus_id'=>$bus_id,'lat'=>$lat,'lon'=>$lon, 'vel'=>$vel];//Determina o array para ser adicionado em Log 
        //$log = $this->Log->patchEntity($log, $logarray);
        //$this->Log->save($log);//Salva Log
        $datas = $this->Data->find('all')->where(['bus_id'=> $bus_id]);//Busca o id de Data na qual o onibus pertence
        foreach ($datas as $data){//Trata o recebido
        }
        $dataarray = ['lat'=>$lat, 'lon'=>$lon, 'vel'=>$vel];//Determina o array para ser subustituido em Data
        $data = $this->Data->patchEntity($data, $dataarray);
        $this->Data->save($data);//Subistitui a posição antiga
    //}
    }
    
    /**
     * Método para atualização do Mapa
     */
    public function map($bus_id){
        $this->viewBuilder()->layout('map');
        $retorno = $this->Data->find('all')->where(['bus_id' => $bus_id]);
        $retorno = $retorno->first();
        $retorno['modified']=$retorno['modified']->timeAgoInWords([
        'accuracy' => 'second']);
        $this->set(compact('retorno'));
    }
    
    public function map2($bus_id){
        $this->viewBuilder()->layout('map2');
        $retorno = $this->Data->find('all')->where(['bus_id' => $bus_id]);
        $retorno = $retorno->first();
        $retorno['modified']=$retorno['modified']->timeAgoInWords([
        'accuracy' => 'second']);
        $this->set(compact('retorno'));
    }
    
    public function hist($bus_id){
        $this->loadModel('Log'); //Carrega a tabela Log no sistema Data
        $this->viewBuilder()->layout('hist');
        $retorno = $this->Log->find('all')->where(['bus_id' => $bus_id]);
        $this->set(compact('retorno'));
    }
    
    
    /**
     * Delete method
     *
     * @param string|null $id Data id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $data = $this->Data->get($id);
        if ($this->Data->delete($data)) {
            $this->Flash->success(__('The data has been deleted.'));
        } else {
            $this->Flash->error(__('The data could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
