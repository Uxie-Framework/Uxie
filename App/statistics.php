<?php
namespace App;

use Models;

class Statistics
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
        //Models\StatisticsHits::insert(['ip', 'browser', 'target', 'track', 'date'], [$this->ip, $this->browser, $this->target, $this->track, $this->date])->save();
    }

    private function uniqVisits()
    {
        if (cookie('visitor')) {
            $this->id = cookie('visitor');
            Models\StatisticsUniq::update(['ip'], [$this->ip])->where('id', '=', $this->id)->save();
            Models\StatisticsUniq::increase('hits', 'hits + 1')->save();
        } else {
            $this->id = uniqid();
            cookie('visitor', $this->id, time() + 3600 * 24 * 30 * 12);
            cookie('hits', 1, time()+3600*24*30*12);
            $fields = ['id', 'ip', 'time', 'hits'];
            $values = [$this->id, $this->ip, $this->date, 1];
            Models\StatisticsUniq::insert($fields, $values)->save();
        }
    }
}
