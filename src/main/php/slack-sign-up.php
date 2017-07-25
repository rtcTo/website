<?php
$php_self = $_SERVER['PHP_SELF'];
if (isset($_REQUEST['firstName'])) {
  $firstName = $_REQUEST['firstName'];
} else {
  $firstName = "";
}
if (isset($_REQUEST['lastName'])) {
  $lastName = $_REQUEST['lastName'];
} else {
  $lastName = "";
}
if (isset($_REQUEST['email'])) {
  $email = $_REQUEST['email'];
} else {
  $email = "";
}
header('Content-Type: text/html; charset=utf-8');
header('refresh:15;url=/index.html');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>rtcTo - Slack sign up</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
<link rel="stylesheet" href="/assets/css/main.css" />
<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
</head>
<body>
<section class="main">
<div class="content style1 dark">
<div class="container">
<section>
<header>
<?php
if ($firstName == "" or $lastName == "" or $email == ""):
  echo "<h3>Sorry, your request could not be processed due missing information</h3>";
else:
  $url = 'https://rtc-to.slack.com/api/users.admin.invite';
  // update using the according token as described here
  // https://github.com/outsideris/slack-invite-automation#issue-token
  $token = 'xoxp-000000000000-000000000000-000000000000-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
  $data = array('email' => $email, 'token' => $token, 'set_active' => 'true');
  // use key 'http' even if you send the request to https://...
  $options = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($data)
    )
  );
  $context  = stream_context_create($options);
  $result = json_decode(file_get_contents($url, false, $context));
  if ($result->ok === FALSE):
    echo "<h3>Sorry $firstName, your request could not be processed</h3>";
    echo "<p>The following error occured: $result->error</p>";
  else:
    echo "<h3>Your invitation request has been submitted</h3>";
    echo "<p>$firstName, your personal invitation should be on the way. Check your're email at $email in a couple minutes.</p>";
  endif;
endif;
?>
</header>
<p>If not redirected within the next seconds, use the following <a href="/index.html">link</a>.
</section>
</div>
</div>
</section>
</body>
</html>
