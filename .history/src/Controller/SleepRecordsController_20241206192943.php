<?php
// src/Controller/SleepRecordsController.php
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
        $sleepRecord = $this->SleepRecords->get($id, contain: ['Users']);
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
        $users = $this->SleepRecords->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('sleepRecord', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sleep Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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
        $users = $this->SleepRecords->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('sleepRecord', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sleep Record id.
     * @return \Cake\Http\Response|null|void Redirects to index.
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

    /**
     * Weekly Summary method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
<!-- templates/SleepRecords/weekly_summary.php -->
<div class="sleepRecords index content">
    <h3><?= __('Weekly Summary') ?></h3>
    <table>
        <thead>
            <tr>
                <th><?= __('Date') ?></th>
                <th><?= __('Sleep Cycles') ?></th>
                <th><?= __('Mood') ?></th>
                <th><?= __('Sport') ?></th>
                <th><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sleepRecords as $sleepRecord): ?>
            <tr>
                <td><?= h($sleepRecord->date) ?></td>
                <td><?= $sleepRecord->sleep_cycles ?></td>
                <td><?= h($sleepRecord->mood) ?></td>
                <td><?= $sleepRecord->sport ? __('Yes') : __('No') ?></td>
                <td><?= $this->Html->link(__('View'), ['controller' => 'SleepRecords', 'action' => 'view', $sleepRecord->id]) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <h4><?= __('Total Sleep Cycles: ') . $totalSleepCycles ?></h4>
        <div>
            <span style="color: <?= $totalSleepCycles >= 42 ? 'green' : 'red' ?>;">●</span> <?= __('Total Sleep Cycles Indicator') ?>
        </div>
        <h4><?= __('Consecutive Days with >= 5 Cycles: ') . $consecutiveDays ?></h4>
        <div>
            <span style="color: <?= $consecutiveDays >= 4 ? 'green' : 'red' ?>;">●</span> <?= __('Consecutive Days Indicator') ?>
        </div>
    </div>

    <canvas id="sleepChart" width="400" height="200"></canvas>
    <script>
    var ctx = document.getElementById('sleepChart').getContext('2d');
    var sleepChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_map(function($record) { return $record->date; }, $sleepRecords)) ?>,
            datasets: [{
                label: 'Sleep Cycles',
                data: <?= json_encode(array_map(function($record) { return $record->sleep_cycles; }, $sleepRecords)) ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</div>
}
