<?php

class GermanDate extends DateTime
{
    /**
     * GermanDate constructor.
     * @param string $time
     * @param null $timezone
     * @param int $addSubDays
     * @param int $addSubHours
     * @param int $addSubSeconds
     */
    function __construct($time = "now", $timezone = NULL, $addSubDays = 0, $addSubHours = 0, $addSubSeconds = 0)
    {
        /* If a timestamp gets passed check it & set */
        if ($this->isValidTimestamp($time)) {
            parent::__construct("now", $timezone);
            $this->setTimestamp($time);
        } else {
            parent::__construct($time, $timezone);
        }

        /* Check if we have to add or subtract or ignore */
        if ($addSubDays > 0)
            $this->addDays($addSubDays);
        else if ($addSubDays < 0)
            $this->subDays($addSubDays * -1);

        if ($addSubHours > 0)
            $this->addHours($addSubHours);
        else if ($addSubHours < 0)
            $this->subHours($addSubHours * -1);

        if ($addSubSeconds > 0)
            $this->addSeconds($addSubSeconds);
        else if ($addSubSeconds < 0)
            $this->subSeconds($addSubSeconds * -1);
    }

    /**
     * @param $timestamp
     * @return bool
     */
    private function isValidTimestamp($timestamp)
    {
        return ((string)(int)$timestamp === $timestamp)
            && ($timestamp <= PHP_INT_MAX)
            && ($timestamp >= ~PHP_INT_MAX);
    }

    /* Add time methods */
    public function addSeconds($add)
    {
        $this->setTimestamp($this->getTimestamp() + intval($add));
    }

    public function addMinutes($add)
    {
        $this->addSeconds($add * 60);
    }

    public function addHours($add)
    {
        $this->addMinutes($add * 60);
    }

    public function addDays($add)
    {
        $this->addHours($add * 24);
    }

    public function addYears($add)
    {
        $this->addDays($add * 365);
    }

    /* Subtract time methods */
    public function subSeconds($sub)
    {
        $this->setTimestamp($this->getTimestamp() - intval($sub));
    }

    public function subMinutes($sub)
    {
        $this->subSeconds($sub * 60);
    }

    public function subHours($sub)
    {
        $this->subMinutes($sub * 60);
    }

    public function subDays($sub)
    {
        $this->subHours($sub * 24);
    }

    public function subYears($sub)
    {
        $this->subDays($sub * 365);
    }

    /**
     * @param string $format
     * @return mixed|string
     */
    public function format($format)
    {
        if ($format === 'l' || $format === 'F' || $format === 'U') {
            $eng = $this->eng_lang;
            $ger = $this->ger_lang;
        } else {
            $eng = $this->eng_kurz;
            $ger = $this->ger_kurz;
        }
        return str_replace($eng, $ger, parent::format($format));
    }

    /**
     * Returned den Deutschen Tagnamen
     * @param bool $short
     * @return mixed|string
     */
    public function getGermanDayName($short = false)
    {
        if ($short)
            return $this->format("D");
        return $this->format("l");
    }

    /**
     * Returned den Deutschen Monatsnamen
     * @param bool $short
     * @return string
     */
    public function getGermanMonthName($short = false)
    {
        if ($short)
            return $this->format("F");
        return $this->format("M");
    }

    /**
     * Formatiert ein Datum in ein deutsches Datum mit Uhrzeit nach dem DIN
     * @param bool $alphanumeric
     * @param bool $showSeconds
     * @param bool $extension
     * @return string
     */
    public function getGermanDatetime($alphanumeric = false, $showSeconds = true, $extension = false)
    {
        return
            $this->getGermanDate($alphanumeric)
            . ' '
            . $this->getGermanTime($showSeconds)
            . ($extension ? ' Uhr' : '');
    }

    /**
     * Formatiert ein Datum in ein deutsches Datum nach dem DIN
     * @param bool $alphanumeric
     * @return string
     */
    public function getGermanDate($alphanumeric = false)
    {
        return
            $alphanumeric ?
                // True
                $this->format("d. F Y") :
                // False
                $this->format("d.m.Y");
    }

    /**
     * Formatiert ein Datum in eine deutsche Zeit nach dem DIN
     * @param bool $showSeconds
     * @return string
     */
    public function getGermanTime($showSeconds = true)
    {
        return
            $showSeconds ?
                // True
                $this->format("H:i:s") :
                // False
                $this->format("H:i");
    }

    protected $eng_lang = array(
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    );

    protected $eng_kurz = array(
        'Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat',
        'Sun',
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec'
    );

    protected $ger_lang = array(
        'Montag',
        'Dienstag',
        'Mittwoch',
        'Donnerstag',
        'Freitag',
        'Samstag',
        'Sonntag',
        'Januar',
        'Februar',
        'März',
        'April',
        'Mai',
        'Juni',
        'Juli',
        'August',
        'September',
        'Oktober',
        'November',
        'Dezember'
    );

    protected $ger_kurz = array(
        'Mo',
        'Di',
        'Mi',
        'Do',
        'Fr',
        'Sa',
        'So',
        'Jan',
        'Feb',
        'Mär',
        'Apr',
        'Mai',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Okt',
        'Nov',
        'Dez'
    );
}