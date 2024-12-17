<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class SleepRecord extends Entity
{
    protected $_accessible = [
        'bedtime' => true,
        'wakeup_time' => true,
        'nap_afternoon' => true,
        'nap_evening' => true,
        'morning_feeling' => true,
        'comment' => true,
        'sport' => true,
    ];

    public function getSleepCycles()
    {
        $bedtime = new \DateTime($this->bedtime);
        $wakeupTime = new \DateTime($this->wakeup_time);
        $interval = $bedtime->diff($wakeupTime);
        $hours = $interval->h + ($interval->i / 60) + ($interval->s / 3600);
        return floor($hours / 1.5); // Assuming each sleep cycle is 1.5 hours
    }

    public function getSleepCycleIndicator()
    {
        $bedtime = new \DateTime($this->bedtime);
        $wakeupTime = new \DateTime($this->wakeup_time);
        $interval = $bedtime->diff($wakeupTime);
        $minutes = ($interval->h * 60) + $interval->i + ($interval->s / 60);
        $remainder = $minutes % 90;
        return ($remainder <= 10 || $remainder >= 80) ? 'green' : 'red';
    }

    public function getWeeklySleepCycles($sleepRecords)
    {
        $totalCycles = 0;
        foreach ($sleepRecords as $record) {
            $totalCycles += $record->getSleepCycles();
        }
        return $totalCycles;
    }

    public function getWeeklyIndicators($sleepRecords)
    {
        $totalCycles = $this->getWeeklySleepCycles($sleepRecords);
        $consecutiveDays = 0;
        $maxConsecutiveDays = 0;
        foreach ($sleepRecords as $record) {
            if ($record->getSleepCycles() >= 5) {
                $consecutiveDays++;
                if ($consecutiveDays > $maxConsecutiveDays) {
                    $maxConsecutiveDays = $consecutiveDays;
                }
            } else {
                $consecutiveDays = 0;
            }
        }
        return [
            'totalCyclesIndicator' => $totalCycles >= 42 ? 'green' : 'red',
            'consecutiveDaysIndicator' => $maxConsecutiveDays >= 4 ? 'green' : 'red'
        ];
    }
}
