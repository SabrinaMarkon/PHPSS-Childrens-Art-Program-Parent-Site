<?php
/**
Handles IPN callbacks from PayPal for member purchases.
PHP 5
@author Sabrina Markon
@copyright 2017 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/
class IPN
{
    public function __construct($raw_post_data) {

        // STEP 1: Read POST data
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode ('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // STEP 2: Post IPN data back to paypal to validate

        $ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        if( !($res = curl_exec($ch)) ) {
            error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit;
        }
        curl_close($ch);

        // STEP 3: Inspect IPN validation result and act accordingly

        if (strcmp ($res, "VERIFIED") == 0) {
            echo "VERIFIED";

            $payment_status = $_POST['payment_status'];
            $amount = $_POST['mc_gross'];
            $payment_currency = $_POST['mc_currency'];
            $txn_id = $_POST['txn_id'];
            $receiver_email = $_POST['receiver_email'];
            $paypal = $_POST['payer_email'];
            $quantity = $_POST['quantity'];
            $username = $_POST['option_selection1'];
            $item = $_POST['item_name'];

            if ($payment_status === "Completed") {

                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $sql = "select * from members where username=?";
                $q = $pdo->prepare($sql);
                $q->execute(array($username));
                $userexists = $q->rowCount();

                if($userexists > 0) {

                    // username exists.
                    $q->setFetchMode(PDO::FETCH_ASSOC);
                    $userdetails = $q->fetch();
                    // get sponsor.
                    $referid = $userdetails->referid;

                    // get the product information from the product ID passed back from paypal:
                    $productid = $_POST["option_selection2"];

                    $sql = "select * from products where id=?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($productid));
                    $productexists = $q->rowCount();

                    if ($productexists > 0) {

                        // product exists.
                        $q->setFetchMode(PDO::FETCH_ASSOC);
                        $productdetails = $q->fetch();
                        // get commission amount.
                        $commission = $productdetails->commission;

                        if ($commission > 0) {
                            // credit commissions (will only work if the sponsor exists and commission is > 0)
                            $sql = "update members set commission=commission+? where username=?";
                            $q = $pdo->prepare($sql);
                            $q->execute(array($commission, $referid));
                        }


                        // add transaction.
                        $datepaid = new DateTime();
                        $datepaid = $datepaid->format('Y-m-d');
                        $transaction = new Transaction;
                        $transaction->userid = $username;
                        $transaction->transaction = $txn_id;
                        $transaction->description = $product->name;
                        $transaction->datepaid = $datepaid;
                        $transaction->amount = $amount;

                        // email admin.
                        $html = "Dear " . $request->get('adminname') . ",<br><br>"
                            . "A new " . $request->get('sitename') . " product was purchased!<br>"
                            . "** You will need to now fulfill the order for the customer! **<br>"
                            . "UserID: " . $username . "<br>"
                            . "Product: " . $product->name . "<br>"
                            . "Quantity: " . $product->quantity . "<br>"
                            . "Amount: " . $amount . "<br>"
                            . "Transaction ID: " . $txn_id . "<br>"
                            . "Sponsor: " . $referid . "<br>"
                            . "Commission: " . $product->commission . "<br><br>"
                            . "" . $request->get('domain') . "<br><br><br>";
                        \Mail::send(array(), array(), function ($message) use ($html, $request) {
                            $message->to($request->get('adminemail'), $request->get('adminname'))
                                ->subject($request->get('sitename') . ' Product Purchase Notification')
                                ->from($request->get('adminemail'), $request->get('adminname'))
                                ->setBody($html, 'text/html');
                        });

                    } else {
                        // product ID doesn't exist.
                        exit;
                    }

                } else {
                    // user not found.
                    exit;
                }

                Database::disconnect();

            } else {
                // status is not completed, so see if it is a cancellation.

            }
        } else if (strcmp ($res, "INVALID") == 0) {
            // invalid payment.
            //  echo "Invalid";
            exit;
        }
        // no view needed.
    }

}