<?php
if (isset($_POST['email'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "matt@seesawstudio.com.au";
    $email_subject = "New form submissions";

    function problem($error)
    {
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br><br>";
        echo $error . "<br><br>";
        echo "Please go back and fix these errors.<br><br>";
        die();
    }

    // validation expected data exists
    if (
        !isset($_POST['fname']) ||
        !isset($_POST['sname']) ||
        !isset($_POST['phone']) ||
        !isset($_POST['email']) ||
        !isset($_POST['city']) ||
        !isset($_POST['postcode'])
    ) {
        problem('We are sorry, but there appears to be a problem with the form you submitted.');
    }

    $fname = $_POST['fname']; // required
    $sname = $_POST['sname']; // required
    $phone = $_POST['phone']; // required
    $email = $_POST['email']; // required
    $city = $_POST['city']; // required
    $postcode = $_POST['postcode']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'The Email address you entered does not appear to be valid.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    $email_message = "Form details below.\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "First Name: " . clean_string($fname) . "\n";
    $email_message .= "Surname: " . clean_string($sname) . "\n";
    $email_message .= "Phone: " . clean_string($phone) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "City: " . clean_string($city) . "\n";
    $email_message .= "Postcode: " . clean_string($postcode) . "\n";

    // create email headers
    $headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $saveFName = "First Name: " . clean_string($fname) . "\n";
    $saveSName = "Surname: " . clean_string($sname) . "\n";
    $savePhone = "Phone: " . clean_string($phone) . "\n";
    $saveEmail = "Email: " . clean_string($email) . "\n";
    $saveCity = "City: " . clean_string($city) . "\n";
    $savePostcode = "Postcode: " . clean_string($postcode) . "\n";
    $file=fopen("saved.txt", "a");
    fwrite($file, $saveFName);
    fwrite($file, $saveSName);
    fwrite($file, $savePhone);
    fwrite($file, $saveEmail);
    fwrite($file, $saveCity);
    fwrite($file, $savePostcode);
    fclose($file);

    @mail($email_to, $email_subject, $email_message, $headers);
?>

    <!-- include your success message below -->

<?php
}
?>