<?php


require_once 'NotORM.php';
$pdo = new PDO('mysql:dbname=a2521372_BP;host=mysql12.000webhost.com', 'a2521372_sysadm', 'sysadm01') ;
$db = new NotORM($pdo);


require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();


$app = new \Slim\Slim();

//Get Method to get the data from database
$app->get('/bp(/:id)', function ($id = null) use ($app, $db) {

    if ($id == null) {
        $data = array();
        foreach ($db->blood_pressure() as $p) {
            $data[] = array(
                'id' => $p['id'],
                'date' => $p['eff_date'],
                'systolic' => $p['systolic'],
                'diastolic' => $p['diastolic'],
                'pulse' => $p['pulse']
            );
        }
    } else {

        $data = null;

        if ($p = $db->blood_pressure()->where('id', $id)->fetch()) {
            $data = array(
                'id' => $p['id'],
                'date' => $p['date'],
                'systolic' => $p['systolic'],
                'diastolic' => $p['diastolic'],
                'pulse' => $p['pulse']
            );
        }
    }

    $app->response()->header('content-type', 'application/json');

    echo json_encode($data);

});
//Post method to insert data into database
$app->post('/bp', function () use ($app, $db) {

    $array = (array)json_decode($app->request()->getBody());
    $data = $db->blood_pressure()->insert($array);

    $app->response()->header('Content-Type', 'application/json');

    echo json_encode($data['id']);

});
//Put method to update the data into database
$app->put('/bp/:id', function ($id) use ($app, $db) {

    $person = $db->blood_pressure()->where('id', $id);
    $data = null;

    if ($person->fetch()) {
        /*
         * We are reading JSON object received in HTTP request body and converting it to array
         */
        $post = (array)json_decode($app->request()->getBody());

        /*
         * Updating Person
         */
        $data = $person->update($post);
    }

    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($data);
});
//Delete method to delete the data into database
$app->delete('/bp/:id', function ($id) use ($app, $db) {
    /*
     * Fetching Person for deleting
     */
    $person = $db->blood_pressure()->where('id', $id);

    $data = null;
    if ($person->fetch()) {
        /*
         * Deleting Person
         */
        $data = $person->delete();
    }

    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($data);
});
$app->run();