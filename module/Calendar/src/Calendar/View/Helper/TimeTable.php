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
        
        //                     echo '<pre>';
        // var_dump($timing['timeStart']);
        // echo '</pre>';
        // die();

            // Begin the table for this square's timing
            $html .= '<table class="calendar-time-table" style="width: 95px;">';
            
            // Date row (empty placeholder for alignment)
            $html .= '<tr class="calendar-date-row"><td>&nbsp;</td></tr>';
            
            // Square type row
            $html .= sprintf(
                '<tr class="calendar-square-row"><td>%s</td></tr>',
                $view->option('subject.square.type')
            );

            // Loop to create time blocks within the square's timing range
            foreach ($squareTimings as $timing) {
                $html .= '<tr class="calendar-core-row"><td>';
                
                // Format the time range for this block (start to end time)
                $html .= sprintf(
                    '<div class="cts-label">%s</div> <div class="cte-label">%s %s</div>',
                    $view->timeFormat($timing['timeStart'], false, 'UTC'), // Start time
                    $view->translate('to'), // "to" text translation
                    $view->timeFormat($timing['timeStart'] + $timing['timeBlock'], true, 'UTC', true) // End time
                );
                
                $html .= '</td></tr>';
            }

            // Square type row (no-print for styling)
            $html .= sprintf(
                '<tr class="calendar-square-row no-print"><td>%s</td></tr>',
                $view->option('subject.square.type')
            );

            // Empty date row (no-print for styling)
            $html .= '<tr class="calendar-date-row no-print"><td>&nbsp;</td></tr>';

            // Close the table
            $html .= '</table>';
        

        // Return the complete HTML output
        return $html;
    }
}
