<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/2/18
 * Time: 11:45 AM
 */
class meta
{
    public static function meta_data()
    {
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }
}