<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SleepRecord> $sleepRecords
 * @var int $weekOffset
 * @var string $period
 * @var float $totalSleepCycles
 * @var float $averageSleepCycles
 * @var int $consecutiveDays
 * @var string $totalCyclesIndicator
 * @var string $consecutiveDaysIndicator
 * @var \App\Model\Entity\SleepRecord $lastRecord
 * @var float $lastRecordPercentage
 */
?>
<div class="sleepRecords index content">
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'Week')"><?= __('Weekly Summary') ?></button>
        <button class="tablinks" onclick="openTab(event, 'Month')"><?= __('Monthly Summary') ?></button>
    </div>

    <div id="Week" class="tabcontent" style="display: <?= $period === 'week' ? 'block' : 'none' ?>;">
        <div class="navigation-buttons">
            <?= $this->Html->link(__('Semaine précédente'), ['action' => 'weeklySummary', $weekOffset - 1, 'week'], ['class' => 'button week-button']) ?>
            <?= $this->Html->link(__('Semaine suivante'), ['action' => 'weeklySummary', $weekOffset + 1, 'week'], ['class' => 'button week-button']) ?>
        </div>
        <h3><?= __('Gestion du sommeil - Récapitulatif de la semaine') ?></h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th><?= __('Date') ?></th>
                        <th><?= __('Cycles de sommeil') ?></th>
                        <th><?= __('Humeur') ?></th>
                        <th><?= __('Sport') ?></th>
                        <th><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sleepRecords as $sleepRecord): ?>
                    <tr>
                        <td><?= h($sleepRecord->date) ?></td>
                        <td><?= $this->Number->format($sleepRecord->sleep_cycles) ?></td>
                        <td><?= h($sleepRecord->mood) ?></td>
                        <td><?= $sleepRecord->sport ? __('Yes') : __('No') ?></td>
                        <td><?= $this->Html->link(__('Voir'), ['action' => 'view', $sleepRecord->id]) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="summary-details">
            <h4><?= __('Nombre total de cycles de sommeil : ') . $totalSleepCycles ?></h4>
            <h4><?= __('Cycles de sommeil moyens : ') . number_format($averageSleepCycles, 2) ?></h4>
            <h4><?= __('Jours consécutifs avec au moins 5 cycles: ') . $consecutiveDays ?> <span style="color: <?= $consecutiveDaysIndicator ?>;">●</span></h4>
            <h4><?= __('Dernier pourcentage d enregistrement : ') . number_format($lastRecordPercentage, 2) . '%' ?></h4>
            <h4><?= __('Indicateur de cycles totaux : ') ?><span style="color: <?= $totalCyclesIndicator ?>;">●</span></h4>
        </div>
        <div class="charts-container">
            <canvas id="sleepChartWeek" width="200" height="200"></canvas>
            <canvas id="pieChartWeek" width="200" height="200"></canvas>
        </div>
    </div>

    <div id="Month" class="tabcontent" style="display: <?= $period === 'month' ? 'block' : 'none' ?>;">
        <div class="navigation-buttons">
            <?= $this->Html->link(__('Semaine précédente'), ['action' => 'weeklySummary', $weekOffset - 1, 'month'], ['class' => 'button month-button']) ?>
            <?= $this->Html->link(__('Semaine suivante'), ['action' => 'weeklySummary', $weekOffset + 1, 'month'], ['class' => 'button month-button']) ?>
        </div>
        <h3><?= __('Gestion du sommeil - Récapitulatif du mois') ?></h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th><?= __('Date') ?></th>
                        <th><?= __('Cycles de sommeil') ?></th>
                        <th><?= __('Humeur') ?></th>
                        <th><?= __('Sport') ?></th>
                        <th><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sleepRecords as $sleepRecord): ?>
                    <tr>
                        <td><?= h($sleepRecord->date) ?></td>
                        <td><?= $this->Number->format($sleepRecord->sleep_cycles) ?></td>
                        <td><?= h($sleepRecord->mood) ?></td>
                        <td><?= $sleepRecord->sport ? __('Yes') : __('No') ?></td>
                        <td><?= $this->Html->link(__('Voir'), ['action' => 'view', $sleepRecord->id]) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div>
            <h4><?= __('Nombre total de cycles de sommeil : ') . $totalSleepCycles ?></h4>
            <h4><?= __('Cycles de sommeil moyens : ') . number_format($averageSleepCycles, 2) ?></h4>
            <h4><?= __('Jours consécutifs avec au moins 5 cycles : ') . $consecutiveDays ?></h4>
            <h4><?= __('Dernier pourcentage d enregistrement ') . number_format($lastRecordPercentage, 2) . '%' ?></h4>
            <h4><?= __('Indicateur de cycles totaux : ') ?><span style="color: <?= $totalCyclesIndicator ?>;">●</span></h4>
            <h4><?= __('Indicateur de jours consécutifs : ') ?><span style="color: <?= $consecutiveDaysIndicator ?>;">●</span></h4>
        </div>
        <div class="charts-container">
            <canvas id="sleepChartMonth" width="200" height="200"></canvas>
            <canvas id="pieChartMonth" width="200" height="200"></canvas>
        </div>
    </div>
</div>

<style>
    .charts-container {
        display: flex;
        justify-content: space-between;
    }
    .charts-container canvas {
        flex: 1;
        max-width: 45%;
    }
    .navigation-buttons {
        margin-bottom: 10px;
    }
    .week-button {
        display: none;
    }
    .month-button {
        display: none;
    }

        .summary-details h4 {
        display: inline-block;
        margin-right: 20px;
    }
</style>

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

        // Show or hide navigation buttons
        var weekButtons = document.getElementsByClassName("week-button");
        var monthButtons = document.getElementsByClassName("month-button");
        if (tabName === 'Week') {
            for (i = 0; i < weekButtons.length; i++) {
                weekButtons[i].style.display = "inline-block";
            }
            for (i = 0; i < monthButtons.length; i++) {
                monthButtons[i].style.display = "none";
            }
        } else {
            for (i = 0; i < weekButtons.length; i++) {
                weekButtons[i].style.display = "none";
            }
            for (i = 0; i < monthButtons.length; i++) {
                monthButtons[i].style.display = "inline-block";
            }
        }

        // Save the active tab to localStorage
        localStorage.setItem('activeTab', tabName);

        // Initialize charts for the selected tab
        initializeCharts(tabName);
    }

    function initializeCharts(tabName) {
        var ctx, pieCtx;
        if (tabName === 'Week') {
            ctx = document.getElementById('sleepChartWeek').getContext('2d');
            pieCtx = document.getElementById('pieChartWeek').getContext('2d');
        } else {
            ctx = document.getElementById('sleepChartMonth').getContext('2d');
            pieCtx = document.getElementById('pieChartMonth').getContext('2d');
        }

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_map(function($record) { return $record->date; }, $sleepRecords)) ?>,
                datasets: [{
                    label: 'Sleep Cycles',
                    data: <?= json_encode(array_map(function($record) { return $record->sleep_cycles; }, $sleepRecords)) ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'Mood',
                    data: <?= json_encode(array_map(function($record) { return $record->mood; }, $sleepRecords)) ?>,
                    borderColor: 'rgba(153, 102, 255, 1)',
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

        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Average Sleep Cycles', 'Last Record Sleep Cycles'],
                datasets: [{
                    data: [<?= number_format($averageSleepCycles, 2) ?>, <?= $lastRecord ? $lastRecord->sleep_cycles : 0 ?>],
                    backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                var total = context.dataset.data.reduce(function(previousValue, currentValue) {
                                    return previousValue + currentValue;
                                });
                                var percentage = (context.raw / total * 100).toFixed(2);
                                label += context.raw + ' (' + percentage + '%)';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }

    // Open the default tab or the saved tab
    window.onload = function() {
        var activeTab = localStorage.getItem('activeTab') || 'Week';
        document.getElementById(activeTab).style.display = "block";
        var tablinks = document.getElementsByClassName("tablinks");
        for (var i = 0; i < tablinks.length; i++) {
            if (tablinks[i].textContent === activeTab + ' Summary') {
                tablinks[i].className += " active";
            }
        }

        // Show or hide navigation buttons based on the active tab
        var weekButtons = document.getElementsByClassName("week-button");
        var monthButtons = document.getElementsByClassName("month-button");
        if (activeTab === 'Week') {
            for (i = 0; i < weekButtons.length; i++) {
                weekButtons[i].style.display = "inline-block";
            }
            for (i = 0; i < monthButtons.length; i++) {
                monthButtons[i].style.display = "none";
            }
        } else {
            for (i = 0; i < weekButtons.length; i++) {
                weekButtons[i].style.display = "none";
            }
            for (i = 0; i < monthButtons.length; i++) {
                monthButtons[i].style.display = "inline-block";
            }
        }

        // Initialize charts for the active tab
        initializeCharts(activeTab);
    };
</script>
