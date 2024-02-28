<?php

namespace Alexandreo\ItauBoleto\Client\Requests;

/**
 *
 */
trait Request
{

    /**
     * @return false|string
     */
    public function toJson()
    {
        $data['data'] = $this->removeNullValues(array_map(function ($value) {
            if ($value instanceof \Alexandreo\ItauBoleto\Client\ItauRequest) {
                return get_object_vars($value);
            } elseif (is_array($value)) {
                return $this->checkForObject($value);
            }
            return $value;
        }, (array) get_object_vars($this)));

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * @param $array
     * @return mixed
     */
    private function checkForObject($array)
    {
        foreach ($array as $key => $value) {
            if (is_object($value)) {
                if (!$value instanceof \Alexandreo\ItauBoleto\Client\ItauRequest) {
                    throw new \InvalidArgumentException('The object must be an instance of ItauRequest');
                }
                $array[$key] = get_object_vars($value);
            } elseif (is_array($value)) {
                $array[$key] = $this->checkForObject($value);
            }
        }
        return $array;
    }

    /**
     * @param $array
     * @return mixed
     */
    private function removeNullValues($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value) || is_object($value)) {
                if (is_object($value)) {
                    $value = get_object_vars($value);
                }

                if (count($value) == 0) {
                    unset($array[$key]);
                    continue;
                }

                $array[$key] = $this->removeNullValues($value);
            } elseif (is_null($value)) {
                unset($array[$key]);
            }
        }
        return $array;
    }

}