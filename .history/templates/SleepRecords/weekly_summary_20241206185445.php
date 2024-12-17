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
