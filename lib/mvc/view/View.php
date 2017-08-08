<?php
namespace Calendar\mvc;

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
  
    private function page() {
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
            <h2 class="page-header">'.date('F', $this->dmyToTime($thisday,$thismonth,$thisyear)).' '.$thisyear.'</div>
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
        $firstdayoftheweek = date('N',$this->dmyToTime(1));
        $filler = $firstdayoftheweek - 1;
        
        for ($i=0; $i<$filler; $i++) {
            $out .= '
                    <td class="filler"></td>';
        }
        
        // now we can start looping through the days of the month
        $day = 1;
        //echo 'time = '.$thisyear.$thismonth.$this->fullDay($day);
        //echo '<br/>return value = '.$this->validateDate($thisyear.$thismonth.$this->fullDay($day));
        while ($this->validateDate($thisyear.$thismonth.$this->fullday($day))) {
            if ($this->dayNumber($day, $thismonth, $thisyear) == 1) { 
                $out .= '
                <tr>';                 
            }
            $out .= '
                    <td';
            // check if today
            if ($day == $thisday) { $out .= ' class="today" '; }
            $out .= '>'.$day.'</td>';
            if ($this->dayNumber($day, $thismonth, $thisyear) == 7) { 
                $out .= '
                </tr>';                
            } 
            $day++;
        }
        
        // Trailing Filler
        $lastday = $day - 1;
        $lastdayoftheweek = $this->dayNumber($lastday, $thismonth, $thisyear);
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
    </div>';
        return $out;
    }
    
    private function dmyToTime(string $day = "",string $month = "",string $year = "")
    {
        if ($day == "")     { $day      = $this->currentDay();      }
        if ($month == "")   { $month    = $this->currentMonth();    }
        if ($year == "")    { $year     = $this->currentYear();     }
        
        // check length
        if (strlen($day) == 1)      { $day      = '0'.$day;     }
        if (strlen($month) == 1)    { $month    = '0'.$month;   }
        if (strlen($year) == 2)     { $year     = '20'.$year;   }
        
        $time = $year.$month.$day;
        return strtotime($time);
    }
    
    private function validateDate($date): bool
    {
        $d = \DateTime::createFromFormat('Ymd', $date);
        return $d && $d->format('Ymd') === $date;
    }
    private function dayNumber($day,$month,$year): int
    {
        return date('N',$this->dmyToTime($day,$month,$year));
    }
    
    private function currentDay() 
    {
        return date('d');
    }           
    private function currentMonth()
    {
        return date('m');
    }
    private function currentYear()
    {
        return date('Y');
    }
    
    private function fullDay(string $day): string
    {
        if (strlen($day) == 1)      { $day      = '0'.$day;     }
        return $day;
    }
      
    
    /* 
     * SETTERS
     */
    public function setCss($css) {
        $this->css = '<link rel="stylesheet" href="'.$css.'"/>';
    }

}
