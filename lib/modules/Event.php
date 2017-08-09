<?php
namespace freest\calendar\modules;

use freest\modules\DB\DBC as DBC;

/**
 * Description of Event
 *
 * @author myrmidex
 */
class Event 
{
    private $id;
    private $event_datetime;
    private $title;
    private $date_added;
    
    public function __construct(int $eid) 
    {
        $this->id = $eid;
        $sql = "SELECT event_datetime, title, date_added 
                FROM events 
                WHERE id = '".$this->id."';";
        $dbc = new DBC();
        $q = $dbc->query($sql) or die("ERROR Event.php - ".$dbc->error());
        if ($q->num_rows == 0) {  die("ERROR Event.php - ID does not exist."); }
        $row = $q->fetch_assoc();
        $this->event_datetime = $row['event_datetime'];
        $this->title          = $row['title'];
        $this->date_added     = $row['date_added'];
        $dbc->close();
    }
    
    public function eventDatetime()
    {
        return $this->event_datetime;
    }
    public function title()
    {
        return $this->title;
    }
    public function dateAdded()
    {
        return $this->date_added;
    }
}
