<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SleepRecord $sleepRecord
 */

// Fonction pour calculer les tranches de cycles de sommeil
function calculateSleepCycleTranches($bedtime, $wakeupTime) {
    $tranches = [];
    $cycleDuration = 90; // Durée d'un cycle en minutes (1h30)

    $bedtime = new DateTime($bedtime);
    $wakeupTime = new DateTime($wakeupTime);

    while ($bedtime < $wakeupTime) {
        $endCycle = clone $bedtime;
        $endCycle->modify("+{$cycleDuration} minutes");

        if ($endCycle > $wakeupTime) {
            break;
        }

        $tranches[] = $bedtime->format('H:i') . ' - ' . $endCycle->format('H:i');
        $bedtime = $endCycle;
    }

    return $tranches;
}

$sleepCycleTranches = calculateSleepCycleTranches($sleepRecord->bedtime, $sleepRecord->wakeup_time);
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
                    <td><?= $sleepRecord->sleep_cycles ?></td>
                </tr>
                <tr>
                    <th><?= __('Cycle Indicator') ?></th>
                    <td><span style="color: <?= $sleepRecord->sleep_cycle_indicator ?>;">●</span></td>
                </tr>
                <tr>
                    <th><?= __('Sleep Cycle Tranches') ?></th>
                    <td>
                        <ul>
                            <?php if (!empty($sleepCycleTranches)): ?>
                                <?php foreach ($sleepCycleTranches as $tranche): ?>
                                    <li><?= h($tranche) ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li><?= __('No sleep cycle tranches available.') ?></li>
                            <?php endif; ?>
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
