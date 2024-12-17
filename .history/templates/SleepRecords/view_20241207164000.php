<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SleepRecord $sleepRecord
 */

// Calculer les cycles de sommeil et l'indicateur
$bedtime = new \DateTime($sleepRecord->bedtime->i18nFormat('yyyy-MM-dd HH:mm:ss'));
$wakeupTime = new \DateTime($sleepRecord->wakeup_time->i18nFormat('yyyy-MM-dd HH:mm:ss'));
$interval = $bedtime->diff($wakeupTime);
$minutes = ($interval->h * 60) + $interval->i;
$cycles = floor($minutes / 90);
$remainder = $minutes % 90;
$indicator = ($cycles >= 5 || $remainder <= 10 || $remainder >= 80) ? 'green' : 'red';

// Log values for debugging
\Cake\Log\Log::write('debug', "Bedtime: {$bedtime->format('H:i')}, Wakeup Time: {$wakeupTime->format('H:i')}, Minutes: $minutes, Cycles: $cycles, Remainder: $remainder, Indicator: $indicator");

// Calculer les tranches de cycles de sommeil
$tranches = [];
while ($bedtime < $wakeupTime) {
    $endCycle = clone $bedtime;
    $endCycle->modify('+90 minutes');
    if ($endCycle > $wakeupTime) {
        $endCycle = $wakeupTime;
    }
    $tranches[] = $bedtime->format('H:i') . ' - ' . $endCycle->format('H:i');
    $bedtime = $endCycle;
}

// Log values for debugging
\Cake\Log\Log::write('debug', "Sleep Cycle Tranches: " . implode(', ', $tranches));
?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Sleep Record'), ['action' => 'edit', $sleepRecord->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Sleep Record'), ['action' => 'delete', $sleepRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sleepRecord->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Sleep Records'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Sleep Record'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="sleepRecords view content">
            <h3><?= h($sleepRecord->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $sleepRecord->hasValue('user') ? $this->Html->link($sleepRecord->user->username, ['controller' => 'Users', 'action' => 'view', $sleepRecord->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($sleepRecord->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mood') ?></th>
                    <td><?= $this->Number->format($sleepRecord->mood) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($sleepRecord->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bedtime') ?></th>
                    <td><?= h($sleepRecord->bedtime->format('H:i')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Wakeup Time') ?></th>
                    <td><?= h($sleepRecord->wakeup_time->format('H:i')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sleep Cycles') ?></th>
                    <td><?= $cycles ?></td>
                </tr>
                <tr>
                    <th><?= __('Cycle Indicator') ?></th>
                    <td><span style="color: <?= $indicator ?>;">●</span></td>
                </tr>
                <tr>
                    <th><?= __('Sleep Cycle Tranches') ?></th>
                    <td>
                        <ul>
                            <?php foreach ($tranches as $tranche): ?>
                                <li><?= h($tranche) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($sleepRecord->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($sleepRecord->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nap Afternoon') ?></th>
                    <td><?= $sleepRecord->nap_afternoon ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Nap Evening') ?></th>
                    <td><?= $sleepRecord->nap_evening ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Sport') ?></th>
                    <td><?= $sleepRecord->sport ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Comment') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($sleepRecord->comment)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
