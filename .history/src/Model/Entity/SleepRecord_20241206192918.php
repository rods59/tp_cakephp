<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SleepRecord Entity
 *
 * @property int $id
 * @property int $user_id
 * @property \Cake\I18n\Date $date
 * @property \Cake\I18n\Time $bedtime
 * @property \Cake\I18n\Time $wakeup_time
 * @property bool $nap_afternoon
 * @property bool $nap_evening
 * @property int $mood
 * @property string $comment
 * @property bool $sport
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class SleepRecord extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'user_id' => true,
        'date' => true,
        'bedtime' => true,
        'wakeup_time' => true,
        'nap_afternoon' => true,
        'nap_evening' => true,
        'mood' => true,
        'comment' => true,
        'sport' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];
// In src/Model/Entity/SleepRecord.php
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
