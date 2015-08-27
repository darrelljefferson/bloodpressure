<?php
/**
 * Created by PhpStorm.
 * User: bigdata
 * Date: 8/7/2015
 * Time: 5:56 AM
 */

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$filename = 'Slim/Slim.php';
if (file_exists($filename)) {
    echo phpversion();

} else {
    echo "The file $filename does not exist";
}

try {
    $pd1 = new PDO('mysql:dbname=a2521372_BP;host=mysql12.000webhost.com', 'a2521372_sysadm', 'sysadm01') ;;
    foreach($pd1->query('SELECT * from blood_pressure') as $row) {
       // print_r($row);
    }
    $pd1 = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}





require_once 'NotORM.php';
$pdo = new PDO('mysql:dbname=a2521372_BP;host=mysql12.000webhost.com', 'a2521372_sysadm', 'sysadm01') ;
$db = new NotORM($pdo);



        $data = array();
        foreach ($db->blood_pressure() as $p) {
            $data[] = array(
                'id' => $p['id'],
                'date' => $p['eff_date'],
                'systolic' => $p['systolic'],
                'diastolic' => $p['diastolic'],
                'pulse' => $p['pulse']
            );
        };

// echo json_encode($data);


?>