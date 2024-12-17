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
Sleep Cycles
Cycle Indicator 	●
Sleep Cycle Tranches

    Warning (2) : foreach() argument must be of type array|object, null given [in C:\wamp64\www\cake1\templates\SleepRecords\view.php, line 57] 

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
    $startDate = new \DateTime('last Monday');
    $endDate = new \DateTime('next Sunday');
    $sleepRecords = $this->SleepRecords->find('all', [
        'conditions' => [
            'date >=' => $startDate->format('Y-m-d'),
            'date <=' => $endDate->format('Y-m-d')
        ]
    ])->toArray();

    $totalSleepCycles = array_sum(array_map(function($record) {
        return $record->sleep_cycles;
    }, $sleepRecords));

    $consecutiveDays = 0;
    $currentStreak = 0;
    foreach ($sleepRecords as $record) {
        if ($record->sleep_cycles >= 5) {
            $currentStreak++;
            if ($currentStreak > $consecutiveDays) {
                $consecutiveDays = $currentStreak;
            }
        } else {
            $currentStreak = 0;
        }
    }

    $this->set(compact('sleepRecords', 'totalSleepCycles', 'consecutiveDays'));
}
}
