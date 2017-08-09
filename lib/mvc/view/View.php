<?php
namespace freest\calendar\mvc\view;

use freest\modules\DB\DBC as DBC;
use freest\calendar\modules\Time as Time;

/**
 * Description of View
 *
 * @author myrmidex
 */
class View {

    private $content;
    private $css;
    private $title;
  
    public function __construct() {}
  
  /*
   * Lay-Outs
   */
  
  
  /* Front
   * 
   * Front layout
  */
    public function front() 
    {
        $this->content = $this->drawCalendar();    
        $this->page();
    }
  
    private function page() 
    {
        echo  '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>'.$this->title.'</title>
    <link href="../lib/modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    '.$this->css.' 
  </head>
  <body>
    '.$this->content.'
    <script src="../lib/modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="../lib/modules/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>';
    }
  
    private function drawCalendar(): string
    {
        $this->setCss('css/calendar.css');
        
        // week starts on monday (1)
        define('WEEKSTARTSON', 1);
        $thisyear = date("Y");
        $thismonth = date("m");
        $thisday = date("d");
        
        $weekdays = array('monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6, 'sunday' => 7);
        $weekdaysFormal = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $weekdaysr = array(1 => 'monday', 2 => 'tuesday', 3 => 'wednesday', 4 => 'thursday', 5 => 'friday', 6 => 'saturday', 7 => 'sunday');
        //$out .= '<tr><td>the date is: '.$thisday.' / '.$thismonth.' / '.$thisyear.'</td></tr>';
        
        // This month only until further notice
        $out = '
    <div class="container">
        <div class="row">
            <h2 class="page-header">'.date('F', Time\dmyToTime($thisday,$thismonth,$thisyear)).' '.$thisyear.'</div>
             <table class="table">
                <tr>';
        for ($i=0; $i<7; $i++) {
            $out .= '
                    <th class="col-lg-1">'.$weekdaysFormal[$i].'</th>';
        }         
        
        $out .= ' 
                </tr>
                <tr>';
        // Day 1
        // now we know how much filler we need for the first one.
        $firstdayoftheweek = date('N', Time\dmyToTime(1));
        $filler = $firstdayoftheweek - 1;
        
        for ($i=0; $i<$filler; $i++) {
            $out .= '
                    <td class="filler"></td>';
        }
        
        // now we can start looping through the days of the month
        $day = 1;
        //echo 'time = '.$thisyear.$thismonth.$this->fullDay($day);
        //echo '<br/>return value = '.$this->validateDate($thisyear.$thismonth.$this->fullDay($day));
        while (Time\validateDate($thisyear.$thismonth.Time\fullday($day))) {
            if (Time\dayNumber($day, $thismonth, $thisyear) == 1) { 
                $out .= '
                <tr>';                 
            }
            $out .= '
                    <td';
            // check if today
            if ($day == $thisday) { $out .= ' class="today" '; }
            
            // check days events
            $sql = "SELECT id, title 
                    FROM events 
                    WHERE DAY(event_datetime) = '$day' 
                        AND MONTH(event_datetime) = '$thismonth' 
                        AND YEAR(event_datetime) = '$thisyear';";
            $dbc = new DBC();
            $q = $dbc->query($sql) or die("ERROR View - ".$dbc->error());
            
            $out .= '>
                <a href="#" data-toggle="modal" data-target="#myModal">'.$day;
            while ($row = $q->fetch_assoc()) {
                $out .= '<div class="event"><a href="index.php?view=event&eid='.$row['id'].'">'.$row['title'].'</a></div>';
            }
            $out .= '</a></td>';
            if (Time\dayNumber($day, $thismonth, $thisyear) == 7) { 
                $out .= '
                </tr>';                
            } 
            $day++;
        }
        
        // Trailing Filler
        $lastday = $day - 1;
        $lastdayoftheweek = Time\dayNumber($lastday, $thismonth, $thisyear);
        if ($lastdayoftheweek != 7) {
            $filler = 7 - $lastdayoftheweek;
            for ($i=0; $i<$filler; $i++) {
                $out .= '
                    <td class="filler"></td>';
            }
            $out .= '
                </tr>';
        }   
        
        $out .= '
           </table>
        </div>
        
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Event</h4>
                    </div>
                    <div class="modal-body">
                        <form action="index.php?action=new" method="POST">
                            <div class="form-group">
                                date: 
                                    <input type="text" size="2" name="ne_day" />
                                    <input type="text" size="2" name="ne_month" />
                                    <input type="text" size="4" name="ne_year" />
                            </div>
                            <div class="form-group">
                                Title
                                    <input type="text" name="ne_title" />
                            </div>
                            <input type="hidden" name="addevent" value="go" />
                            <input type="submit" class="btn btn-primary"  value="Add Event" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>';
        return $out;
    }  
    
    /* 
     * SETTERS
     */
    public function setCss($css) {
        $this->css = '<link rel="stylesheet" href="'.$css.'"/>';
    }

}
