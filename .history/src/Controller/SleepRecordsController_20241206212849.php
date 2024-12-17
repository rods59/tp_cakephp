<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SleepRecords Controller
 *
 * @property \App\Model\Table\SleepRecordsTable $SleepRecords
 */
class SleepRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->SleepRecords->find()
            ->contain(['Users']);
        $sleepRecords = $this->paginate($query);

        $this->set(compact('sleepRecords'));
    }

    /**
     * View method
     *
     * @param string|null $id Sleep Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sleepRecord = $this->SleepRecords->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('sleepRecord'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sleepRecord = $this->SleepRecords->newEmptyEntity();
        if ($this->request->is('post')) {
            $sleepRecord = $this->SleepRecords->patchEntity($sleepRecord, $this->request->getData());
            if ($this->SleepRecords->save($sleepRecord)) {
                $this->Flash->success(__('The sleep record has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sleep record could not be saved. Please, try again.'));
        }
        $this->set(compact('sleepRecord'));
    }

    public function edit($id = null)
    {
        $sleepRecord = $this->SleepRecords->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sleepRecord = $this->SleepRecords->patchEntity($sleepRecord, $this->request->getData());
            if ($this->SleepRecords->save($sleepRecord)) {
                $this->Flash->success(__('The sleep record has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sleep record could not be saved. Please, try again.'));
        }
        $this->set(compact('sleepRecord'));
    }
    /**
     * Delete method
     *
     * @param string|null $id Sleep Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sleepRecord = $this->SleepRecords->get($id);
        if ($this->SleepRecords->delete($sleepRecord)) {
            $this->Flash->success(__('The sleep record has been deleted.'));
        } else {
            $this->Flash->error(__('The sleep record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

 public function weeklySummary()
    {
        $sleepRecords = $this->SleepRecords->find('all', [
            'conditions' => ['date >=' => date('Y-m-d', strtotime('last Monday')), 'date <=' => date('Y-m-d', strtotime('next Sunday'))]
        ])->toArray();

        $totalSleepCycles = array_sum(array_map(function($record) {
            return $record->getSleepCycles();
        }, $sleepRecords));

        $consecutiveDays = 0;
        $maxConsecutiveDays = 0;
        foreach ($sleepRecords as $record) {
            if ($record->getSleepCycles() >= 5) {
                $consecutiveDays++;
                if ($consecutiveDays > $maxConsecutiveDays) {
                    $maxConsecutiveDays = $consecutiveDays;
                }
            } else {
                $consecutiveDays = 0;
            }
        }

        $this->set(compact('sleepRecords', 'totalSleepCycles', 'consecutiveDays', 'maxConsecutiveDays'));
    }
}
