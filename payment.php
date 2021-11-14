<?php
//DEPENDENCIES
require('Stripe.php');
$data_config = include "config.php";
$db = new PDO('mysql:host=localhost;dbname='.$data_config[0], ''.$data_config[1], ''.$data_config[2]);

//GET FORM INFORMATIONS
$username = addslashes(str_replace('<', '', str_replace('>', '', $_POST["username"])));;
$email = addslashes(str_replace('<', '', str_replace('>', '', $_POST["email"])));
$password = $_POST["password"];
$to_echo = "";


if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($username)) {
    //STRIPE MANAGEMENT
        $token = $_POST["stripeToken"];
        $stripe = new Stripe($data_config[4]);

        //New account on Stripe
        $customer = $stripe->api('customers', [
            'source' => $token,
            'description' => $username,
            'email' => $email
        ], $data_config[4]);

        //New paiement
        $charges = $stripe->api('charges', [
            'amount' => $data_config[5],
            'currency' => 'eur', // by default in EURO devise
            'customer' => $customer->id
        ], $data_config[5]);

        //DISPLAYS MANAGEMENT
        if (!property_exists($customer, 'error') && !property_exists($charges, 'error')) {
            //CONFIG property CREATE_ACCOUNT_ON_DB is true ?
            if($data_config[6]){
                //DB MANAGEMENT
                $password = password_hash($password, PASSWORD_DEFAULT);;
                $sql = "SELECT * FROM users where email = '$email'";
                $result = $db->prepare($sql);
                $result->execute();
                //Account already exist ?
                if ($result->rowCount() <= 0) {
                    $sql = "INSERT INTO users (id,username,email,password) VALUES ('$customer->id','$username','$email','$password')";
                    $req = $db->prepare($sql);
                    $req->execute();
                    $to_echo = "<p style='color:green;size: 50px'>PAYMENT doned-> Account created</p><br><img src='https://cdn.dribbble.com/users/603228/screenshots/2322642/comp-1_1.gif'>";
                } else {
                    $to_echo = "<p style='color:red;size: 50px'>account already exist</p>";
                }
            } else {
                $to_echo = "<p style='color:green;size: 50px'>PAYMENT doned</p><br><img src='https://cdn.dribbble.com/users/603228/screenshots/2322642/comp-1_1.gif'>";
            }
        } else {
            $to_echo = "<p style='color:red;size: 50px'>ERROR PLEASE RETRY</p>";
        }
} else {
    $to_echo = "<p style='color:red;size: 50px'>ERROR PLEASE RETRY</p>";
}
?>

<head>
    <meta charset="UTF-8">
    <title>RESULT</title>
</head>
<body>
    <center><?php echo $to_echo ?></center>
</body>

