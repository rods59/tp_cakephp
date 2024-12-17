<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SleepRecord> $sleepRecords
 */
$weekOffset = $weekOffset ?? 0; // Définir une valeur par défaut si $weekOffset n'est pas défini
?>
<div class="sleepRecords index content">
    <?= $this->Html->link(__('Nouvel enregistrement de sommeil'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'Week')"><?= __('Recap de la Semaine') ?></button>
        <button class="tablinks" onclick="openTab(event, 'Month')"><?= __('Recap du Mois') ?></button>
    </div>

    <div id="Week" class="tabcontent">
        <?= $this->Html->link(__('Semaine précédente'), ['action' => 'weeklySummary', $weekOffset - 1, 'week'], ['class' => 'button']) ?>
        <?= $this->Html->link(__('Semaine suivante'), ['action' => 'weeklySummary', $weekOffset + 1, 'week'], ['class' => 'button']) ?>
        <h3><?= __('Gestion du sommeil - Récapitulatif de la semaine') ?></h3>
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
                            <?= $this->Html->link(__('Voir'), ['action' => 'view', $sleepRecord->id]) ?>
                            <?= $this->Html->link(__('Editer'), ['action' => 'edit', $sleepRecord->id]) ?>
                            <?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $sleepRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sleepRecord->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="Month" class="tabcontent">
        <?= $this->Html->link(__('Semaine précédente'), ['action' => 'weeklySummary', $weekOffset - 1, 'month'], ['class' => 'button']) ?>
        <?= $this->Html->link(__('Semaine suivante'), ['action' => 'weeklySummary', $weekOffset + 1, 'month'], ['class' => 'button']) ?>
        <h3><?= __('Gestion du sommeil - Récapitulatif du mois') ?></h3>
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
                            <?= $this->Html->link(__('Voir'), ['action' => 'view', $sleepRecord->id]) ?>
                            <?= $this->Html->link(__('Editer'), ['action' => 'edit', $sleepRecord->id]) ?>
                            <?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $sleepRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sleepRecord->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('précédent')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('suivant') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page n°{{page}} sur {{pages}}, montrant {{current}} enregistrements sur {{count}} au total')) ?></p>
    </div>
</div>

<script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Open the default tab
    document.getElementsByClassName('tablinks')[0].click();
</script>
