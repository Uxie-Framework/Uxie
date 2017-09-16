<?php

namespace App;

class statistics
{
    private $statisticsHits;
    private $id;
    private $ip;
    private $browser;
    private $target;
    private $track;
    private $date;

    public function __construct()
    {
        $this->statisticsHits = new \Models\statistics_hits();
        $this->id = uniqid(uniqid());
        $this->target = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $this->track = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $this->ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $this->ip = $_SERVER['REMOTE_ADDR'];
        }
        $this->browser = $_SERVER['HTTP_USER_AGENT'];
        $this->date = date('y/m/d H:i:s');
        $this->hits();
        $this->uniqVisits();
    }

    private function hits()
    {
        $this->statisticsHits->insert(['ip', 'browser', 'target', 'track', 'date'], [$this->ip, $this->browser, $this->target, $this->track, $this->date]);
    }

    private function uniqVisits()
    {
        $statisticsUniq = new \Models\statistics_uniq();
        if (isset($_COOKIE['visitor'])) {
            $this->id = $_COOKIE['visitor'];
            $statisticsUniq->query("update statistics_uniq set hits=hits+1 where id='$this->id'");
        } else {
            $this->id = uniqid();
            setcookie('visitor', $this->id, time() + 3600 * 24 * 30 * 12);
            $statisticsUniq->insert(['id', 'ip', 'time', 'hits'], [$this->id, $this->ip, $this->date, 1]);
        }
    }
}
