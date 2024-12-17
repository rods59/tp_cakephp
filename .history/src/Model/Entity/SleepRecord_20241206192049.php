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
    protected function _getSleepCycles()
    {
        $bedtime = new \DateTime($this->bedtime);
        $wakeupTime = new \DateTime($this->wakeup_time);
        $interval = $bedtime->diff($wakeupTime);
        $hours = $interval->h + ($interval->i / 60) + ($interval->s / 3600);
        return floor($hours / 1.5); // Assuming each sleep cycle is 1.5 hours
    }

    protected function _getSleepCycleIndicator()
    {
        $bedtime = new \DateTime($this->bedtime);
        $wakeupTime = new \DateTime($this->wakeup_time);
        $interval = $bedtime->diff($wakeupTime);
        $minutes = ($interval->h * 60) + $interval->i + ($interval->s / 60);
        $remainder = $minutes % 90;
        return ($remainder <= 10 || $remainder >= 80) ? 'green' : 'red';
    }

    protected function _getSleepCycleTranches()
    {
        $bedtime = new \DateTime($this->bedtime);
        $wakeupTime = new \DateTime($this->wakeup_time);
        $interval = $bedtime->diff($wakeupTime);
        $minutes = ($interval->h * 60) + $interval->i + ($interval->s / 60);
        $tranches = [];
        while ($bedtime < $wakeupTime) {
            $start = clone $bedtime;
            $end = clone $bedtime;
            $end->modify('+90 minutes');
            if ($end > $wakeupTime) {
                $end = $wakeupTime;
            }
            $tranches[] = $start->format('H:i') . ' - ' . $end->format('H:i');
            $bedtime->modify('+90 minutes');
        }
        return $tranches;
    }
        }
        return $tranches;
    }
}
