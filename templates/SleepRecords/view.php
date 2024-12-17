<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SleepRecord $sleepRecord
 */

$cycles = $sleepRecord->sleep_cycles;
$indicator = $sleepRecord->sleep_cycle_indicator;
$tranches = $sleepRecord->sleep_cycle_tranches;
?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Action') ?></h4>
            <?= $this->Html->link(__('Editer un enregistrement du sommeil'), ['action' => 'edit', $sleepRecord->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Supprimer un enregistrement du sommeil'), ['action' => 'delete', $sleepRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sleepRecord->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Listes des enregistrement du sommeil'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Nouvel enregistrement du sommeil'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Recapitulatif de la semaine'), ['action' => 'weeklySummary'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="sleepRecords view content">
            <h3><?= h($sleepRecord->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Utilisateur :') ?></th>
                    <td><?= $sleepRecord->hasValue('user') ? $this->Html->link($sleepRecord->user->username, ['controller' => 'Users', 'action' => 'view', $sleepRecord->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($sleepRecord->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Humeur :') ?></th>
                    <td><?= $this->Number->format($sleepRecord->mood) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($sleepRecord->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Coucher :') ?></th>
                    <td><?= h($sleepRecord->bedtime->format('H:i')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Réveil :') ?></th>
                    <td><?= h($sleepRecord->wakeup_time->format('H:i')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cycle de sommeil :') ?></th>
                    <td><?= $cycles ?></td>
                </tr>
                <tr>
                    <th><?= __('Indicateur :') ?></th>
                    <td><span style="color: <?= $indicator ?>;">●</span></td>
                </tr>
                <tr>
                    <th><?= __('Tranche cycle de sommeil : ') ?></th>
                    <td>
                        <ul>
                            <?php foreach ($tranches as $tranche): ?>
                                <li><?= h($tranche) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Crée le :') ?></th>
                    <td><?= h($sleepRecord->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modifie le :') ?></th>
                    <td><?= h($sleepRecord->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sieste après-midi') ?></th>
                    <td><?= $sleepRecord->nap_afternoon ? __('Oui') : __('Non'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Sièste soirée :') ?></th>
                    <td><?= $sleepRecord->nap_evening ? __('Oui') : __('Non'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Sport :') ?></th>
                    <td><?= $sleepRecord->sport ? __('Oui') : __('Non'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Commentaire :') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($sleepRecord->comment)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
