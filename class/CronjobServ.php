 <?php

include 'CronjobServ/ThreadLock.php';
include 'CronjobServ/Status.php';

class CronjobServ extends Thread {

  private $slot;
  private $threadId;
  private $Check;
  private $error;

  public function __construct($slot,$threadId,$Check)
  {
      $this->threadId = $threadId;
      $this->slot = $slot;
      $this->Check = $Check;
  }

  public function run()
  {

      #Create a new Database Object
      $DB = new Database;
      $DB->InitDB();

      #Create a new Status Object
      $S = new Status($DB);

      #Create a new ThreadLock Object
      $T = new ThreadLock($DB);

      #Generate the ThreadID
      $THREAD_ID = $this->slot.'_'.$this->threadId;
      $THREAD_LOCK = 0;

      #Set ThreadID
      $T->setThreadLock($THREAD_ID);

      #Check if Thread is locked
      if ($T->getThreadLock() === 0) {

        #Lock the Thread
        $T->setLock();

        foreach ($this->Check as $key => $element) {

          $fp = fsockopen($element['IP'],$element['PORT'], $errno, $errstr, 1.5);

          $S->setID($key);
          $S->getOnlineStatus();

          if (!$fp) {

            //Online => Offline
            if ($S->getStatus() === 1) {

              $S->setStatus(0);

              $time = time();
              $asynchMail = new AsyncMail($element['EMAIL'],'Night-Sky - Downtime Alert '.page::escape($element['NAME']),'Server '.page::escape($element['NAME']).' went offline. Detected: '.date("d.m.Y H:i:s",page::escape($time)));
              $asynchMail->start();

            //Still Offine
            } elseif ($S->getStatus() === 0) {



            }

          } else {

            //Still Online
            if ($S->getStatus() === 1) {



            //Offline => Online
            } elseif ($S->getStatus() === 0) {

              $S->setStatus(1);

              $time = time();
              $asynchMail = new AsyncMail($element['EMAIL'],'Night-Sky - Uptime Alert '.page::escape($element['NAME']),'Server '.page::escape($element['NAME']).' is back Online. Detected: '.date("d.m.Y H:i:s",page::escape($time)));
              $asynchMail->start();

            }

          }

        }

        #Unlock the Thread
        $T->setUnlock();

      }

  }

}

?>
