<?php

$d = "28"; //day
$m = "03"; //month
$y = "2020"; //year

$source = "https://nssac.bii.virginia.edu/covid-19/dashboard/";

$res = array();
$res["status"] = "error";

if (@$csv = fopen($source . "data/nssac-ncov-sd-{$m}-{$d}-{$y}.csv", 'r'))
{

    $res["status"] = "success";
    $res["source"] = $source;

    $i = 0;
    while ($row = fgetcsv($csv))
    {
        if ($i > 0)
        {
            $res["confirmed"] += $row[3];
            $res["deaths"] += $row[4];
            $res["recovered"] += $row[5];
            $res["data"][] = array(
                "name" => $row[0],
                "region" => $row[1],
                "lastupdate" => $row[2],
                "confirmed" => $row[3],
                "deaths" => $row[4],
                "recovered" => $row[5]
            );
        }
        else
        {
            $res["confirmed"] = 0;
            $res["deaths"] = 0;
            $res["recovered"] = 0;
        }
        $i++;
    }

    fclose($csv);
}

header('Content-Type: application/json');
echo json_encode($res, JSON_PRETTY_PRINT);
