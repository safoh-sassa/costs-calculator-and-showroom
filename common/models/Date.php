<?php
namespace common\models;

class Date {

    public static function format($format, $timestamp) {
        if( $format == 'dmy') {
            date_default_timezone_set('Asia/Damascus');
            return date('d M, Y', $timestamp);
        } else if( $format == 'mdy') {
            return date('m-d-Y', $timestamp);
        } else {
            return date('d M, Y', $timestamp);
        }
    }
}