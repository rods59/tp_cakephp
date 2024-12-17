
// In templates/SleepRecords/weekly_summary.php
<div class="sleepRecords index content">
    <h3><?= __('Weekly Summary') ?></h3>
    <table>
        <thead>
            <tr>
                <th><?= __('Date') ?></th>
                <th><?= __('Sleep Cycles') ?></th>
                <th><?= __('Mood') ?></th>
                <th><?= __('Sport') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sleepRecords as $sleepRecord): ?>
            <tr>
                <td><?= h($sleepRecord->date) ?></td>
                <td><?= $sleepRecord->sleep_cycles ?></td>
                <td><?= h($sleepRecord->mood) ?></td>
                <td><?= $sleepRecord->sport ? __('Yes') : __('No') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <h4><?= __('Total Sleep Cycles: ') . $totalSleepCycles ?></h4>
        <h4><?= __('Consecutive Days with >= 5 Cycles: ') . $consecutiveDays ?></h4>
    </div>
</div>
