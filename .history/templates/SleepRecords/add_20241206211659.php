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
        <?php
            echo $this->Form->control('date');
            echo $this->Form->control('bedtime');
            echo $this->Form->control('wakeup_time');
            echo $this->Form->control('nap_afternoon', ['type' => 'checkbox', 'label' => 'Afternoon Nap']);
            echo $this->Form->control('nap_evening', ['type' => 'checkbox', 'label' => 'Evening Nap']);
            echo $this->Form->control('morning_mood', ['type' => 'select', 'options' => range(0, 10), 'label' => 'Morning Mood']);
            echo $this->Form->control('comment', ['type' => 'textarea']);
            echo $this->Form->control('sport', ['type' => 'checkbox', 'label' => 'Sport']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
    </div>
</div>
