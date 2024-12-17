<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SleepRecord $sleepRecord
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Sleep Records'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="sleepRecords form content">
            <?= $this->Form->create($sleepRecord) ?>
<fieldset>
    <legend><?= __('Add Sleep Record') ?></legend>
    <?= $this->Form->control('bedtime', ['type' => 'datetime']) ?>
    <?= $this->Form->control('wakeup_time', ['type' => 'datetime']) ?>
    <?= $this->Form->control('nap_afternoon', ['type' => 'checkbox', 'label' => 'Sieste l’après-midi']) ?>
    <?= $this->Form->control('nap_evening', ['type' => 'checkbox', 'label' => 'Sieste le soir']) ?>
    <?= $this->Form->control('morning_feeling', ['type' => 'select', 'options' => range(0, 10), 'label' => 'Forme au réveil']) ?>
    <?= $this->Form->control('comment', ['type' => 'textarea', 'label' => 'Commentaire']) ?>
    <?= $this->Form->control('sport', ['type' => 'checkbox', 'label' => 'Sport']) ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
        </div>
    </div>
</div>
