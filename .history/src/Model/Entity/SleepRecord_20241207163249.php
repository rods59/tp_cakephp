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

    protected function _getSleepCyclesAndIndicator()
    {
        $bedtime = new \DateTime($this->bedtime->i18nFormat('yyyy-MM-dd HH:mm:ss'));
        $wakeupTime = new \DateTime($this->wakeup_time->i18nFormat('yyyy-MM-dd HH:mm:ss'));
        $interval = $bedtime->diff($wakeupTime);
        $minutes = ($interval->h * 60) + $interval->i;
        $cycles = floor($minutes / 90);
        $remainder = $minutes % 90;

        $indicator = ($cycles >= 5 || $remainder <= 10 || $remainder >= 80) ? 'green' : 'red';

        return [
            'cycles' => $cycles,
            'indicator' => $indicator,
        ];
    }

    protected function _getSleepCycleTranches()
    {
        $bedtime = new \DateTime($this->bedtime->i18nFormat('yyyy-MM-dd HH:mm:ss'));
        $wakeupTime = new \DateTime($this->wakeup_time->i18nFormat('yyyy-MM-dd HH:mm:ss'));
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
        les modifications non rien changer
        return $tranches;
    }
}
