<?php
namespace freest\calendar\mvc\model;

use freest\calendar\modules\Time as Time;
use freest\modules\DB\DBC as DBC;

/**
 * Description of Model
 *
 * @author myrmidex
 */
class Model 
{
    public function __construct() {}

    /* 
     *      FORM PROCESSORS
     */
  
    // NEW EVENT FORM PROCESSOR
    public function fp_event_new(): Array
    {
        if (filter_input(INPUT_POST, 'addevent') == "go") {
            // assuming all checks were done by javascript
            $ne_day = filter_input(INPUT_POST, 'ne_day');
            $ne_month = filter_input(INPUT_POST, 'ne_month');
            $ne_year = filter_input(INPUT_POST, 'ne_year');
            $ne_title = filter_input(INPUT_POST, 'ne_title');
            $sql_date = date("Y-m-d H:i:s", Time\dmyToTime($ne_day,$ne_month,$ne_year));
            $sql = "INSERT INTO events (event_datetime, title, date_added)  
                    VALUES ('$sql_date','$ne_title',NOW());";
            $dbc = new DBC();
            if ($dbc->query($sql)) {
                return array('status' => '1');
            }
            else {
                return array('status' => 'warning',
                            'warning' => $dbc->error());
            }
        }
        else {
            return array('status' => '0');
        }
    }    
    
    // EDIT EVENT FORM PROCESSOR
    
    // DELETE EVENT FORM PROCESSOR
    
    // OTHER FUNCS
    
}
