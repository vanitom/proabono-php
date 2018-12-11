<?php


/**
 * Class Utils
 */


class Utils {


    //---toString-------------------------------------------------------------------------------------------------------
    /**
     * Replace an empty string by a null value.
     *
     * @param $string
     * @return null
     */
    public static function toString($string) {
        // This is a conditional operator.
        return ($string == '')
            ? null
            : $string;
    }
    //------------------------------------------------------------------------------------------------------------------


    //---toLinks--------------------------------------------------------------------------------------------------------
    /**
     * Create an associative array from raw ProAbono links.
     *
     * @param $items All links sended here.
     * @return array $links
     */
    public static function toLinks($items) {

        $links = array();

        if ($items) {
            foreach ($items as $item )  {
                $links[$item->rel] = $item->href;
            }
        }
        return $links;
    }
    //------------------------------------------------------------------------------------------------------------------


    //---urlParam-------------------------------------------------------------------------------------------------------
    /**
     * Append given parameter at the end of the given url.
     *
     * @param $url
     * @param $param
     * @param $value
     * @return string $url
     */
    public static function urlParam($url, $param, $value) {

        // We need all parameters to set the given url:
        if ((isset($url)) && (isset($param)) && (isset($value))) {
            if (strpos($url, '?' )) {
                $url = $url . '&' . $param . '=' . $value;
            } else {
                $url = $url . '?' . $param . '=' . $value;
            }
        }
        return $url;
    }
    //------------------------------------------------------------------------------------------------------------------


}