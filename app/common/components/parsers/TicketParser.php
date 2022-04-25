<?php

namespace app\common\components\parsers;

class TicketParser
{
    private $_ticket;
    private $_format;
    private $_arrivals;

    const XML = 'xml';
    const JSON = 'json';
    const MARK_SEPARATOR = '_';

    public function __construct(array $ticket, string $format = null)
    {
        $this->_ticket = $ticket;
        $this->_format = $format;
    }

    public function getEndpoint()
    {
        if ($this->_format == self::XML) {
            $segments = $this->_ticket['AirSegments'];

            // Get arrivals timestamps
            $this->_arrivals = $this->getArrivalsTimestamps($segments);

            // Calculate fly endpoint
            return $this->calculateFlyEndpoint();

        }

        return [];
    }

    public function getArrivalsTimestamps($segments)
    {
        $arrivals = [];
        foreach ($segments as $segment) {
            $date_time_arr = $segment->Arrival->attributes();
            $timestamp = strtotime($date_time_arr['Date'] . ' ' . $date_time_arr['Time']);
            $city = (string) $segment->Off->attributes()['City'];
            $boarding_city = (string) $segment->Board->attributes()['City'];
            $arrivals[$city . self::MARK_SEPARATOR . $boarding_city . self::MARK_SEPARATOR . $timestamp] = $timestamp;
        }
        asort($arrivals);
        $result = [];
        foreach ($arrivals as $city_mark => $timestamp) {
            $mark_arr = explode(self::MARK_SEPARATOR, $city_mark);
            $result[$city_mark] = [
                'timestamp' => $timestamp,
                'Board' => $mark_arr[1],
                'Off' => $mark_arr[0],
            ];
        }

        return $result;
    }

    public function calculateFlyEndpoint()
    {
        $endpoint_city = null;
        $breakpoint_city = null;
        $max_period = 0;
        foreach ($this->_arrivals as $city_mark => $arr) {
            $next = next($this->_arrivals);
            $city = $arr['Off'];
            if ($next) {
                $period = $next['timestamp'] - $arr['timestamp'];
                if ($period > $max_period) {
                    $max_period = $period;
                    $endpoint_city = $city;
                }
                if($next['Board'] != $arr['Off'] && is_null($breakpoint_city)){
                    $breakpoint_city = $arr['Off'];
                }
            }
        }

        return ['endpoint' => $endpoint_city, 'breakpoint' => $breakpoint_city];
    }
}