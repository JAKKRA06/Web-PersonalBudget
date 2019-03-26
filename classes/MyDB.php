<?php
class MyDB
{
    protected $dbo = null;
    
    function __construct($host, $user, $pass, $db)
    {
        $this->dbo = $this->startConnection($host, $user, $pass, $db);
    }
    
    function startConnection($host, $user, $pass, $db)
    {
        $dbo = new mysqli($host, $user, $pass, $db);
        if ($dbo->connect_errno) {
            $message = "Brak połączenia z bazą danych: " . $dbo->connect_errno;
            throw new Exception($message);
        }
        return $dbo;
    }
    
    function getQuerySingleResult($query)
    {
        if (!$result = $this->dbo->query($query)) {
            return false;
        }
        if ($row = $result->fetch_row()) {
            return $row[0];
        } else {
            return false;
        }
    }
}
?>