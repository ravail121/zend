<?php

namespace Calendar\View\Helper;

use Zend\View\Helper\AbstractHelper;

class TimeTable extends AbstractHelper
{

    public function __invoke($squareTimings)
    {
        $view = $this->getView();
        $html = '';
    
        // Loop over each square's timing
        foreach ($squareTimings as $timing) {
            $timeStart = $timing['timeStart'];
            $timeEnd = $timing['timeEnd'];
            $timeBlock = $timing['timeBlock'];
    
            $html .= '<table class="calendar-time-table" style="width: 95px;">';
            $html .= '<tr class="calendar-date-row"><td>&nbsp;</td></tr>';
            $html .= sprintf('<tr class="calendar-square-row"><td>Square %s</td></tr>', $timing['squareId']);
    
            for ($walkingTime = $timeStart; $walkingTime < $timeEnd; $walkingTime += $timeBlock) {
                $html .= '<tr class="calendar-core-row"><td>';
                $html .= sprintf('<div class="cts-label">%s</div> <div class="cte-label">%s %s</div>',
                    $view->timeFormat($walkingTime, false, 'UTC'), $view->translate('to'), $view->timeFormat($walkingTime + $timeBlock, true, 'UTC', true));
                $html .= '</td></tr>';
            }
    
            $html .= sprintf('<tr class="calendar-square-row no-print"><td>%s</td></tr>',
            $view->option('subject.square.type'));

            $html .= '<tr class="calendar-date-row no-print"><td>&nbsp;</td></tr>';
            $html .= '</table>';
        }
    
        return $html;
    }

}