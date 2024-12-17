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
