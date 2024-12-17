<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SleepRecord> $sleepRecords
 */
?>
<div class="sleepRecords index content">
    <?= $this->Html->link(__('New Sleep Record'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?= $this->Html->link(__('Weekly Summary'), ['action' => 'weeklySummary'], ['class' => 'button float-right']) ?>
    <h3><?= __('Sleep Records') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('bedtime') ?></th>
                    <th><?= $this->Paginator->sort('wakeup_time') ?></th>
                    <th><?= $this->Paginator->sort('nap_afternoon') ?></th>
                    <th><?= $this->Paginator->sort('nap_evening') ?></th>
                    <th><?= $this->Paginator->sort('mood') ?></th>
                    <th><?= $this->Paginator->sort('sport') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sleepRecords as $sleepRecord): ?>
                <tr>
                    <td><?= $this->Number->format($sleepRecord->id) ?></td>
                    <td><?= $sleepRecord->hasValue('user') ? $this->Html->link($sleepRecord->user->username, ['controller' => 'Users', 'action' => 'view', $sleepRecord->user->id]) : '' ?></td>
                    <td><?= h($sleepRecord->date) ?></td>
                    <td><?= h($sleepRecord->bedtime) ?></td>
                    <td><?= h($sleepRecord->wakeup_time) ?></td>
                    <td><?= h($sleepRecord->nap_afternoon) ?></td>
                    <td><?= h($sleepRecord->nap_evening) ?></td>
                    <td><?= $this->Number->format($sleepRecord->mood) ?></td>
                    <td><?= h($sleepRecord->sport) ?></td>
                    <td><?= h($sleepRecord->created) ?></td>
                    <td><?= h($sleepRecord->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $sleepRecord->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sleepRecord->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sleepRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sleepRecord->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
