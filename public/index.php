<?php
include_once 'google-config.php';

if(isset($_GET['code'])){
    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    header('Location: ' . filter_var(REDIRECT_URL, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
	$me = $plus->people->get('me');
	$user_data = array(
        'oauth_uid'     => $me['id'],
        'first_name'    => $me->emails[0]['value'],
    );
    $_SESSION['user_data'] = $user_data;

	$calendarId = 'in.indonesian#holiday@group.v.calendar.google.com';
	$eventList = $calendar->events->listEvents($calendarId);
	//var_dump($eventList->items);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Google Calendar Syncer</title>
        <!-- BOOTSTRAP STYLES-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<style>body { background-color: #eee } .caption { overflow-x: auto }</style>
    </head>
    <body class="hold-transition">
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">Google Calendar</a>
				</div>
				<ul class="nav navbar-nav navbar-right">
					<?php
					if ($client->getAccessToken()) {
						echo '<li><a href="logout.php"><i class="fa fa-google-plus"></i> Sign Out</a></li>';
					} else {
						echo '<li><a href="' . $authUrl . '"><i class="fa fa-google-plus"></i> Sign In</a></li>';
					} ?>
				</ul>
			</div>
		</nav> 
		<div class="container-fluid">
			<h3><?php echo $eventList->summary ?></h3>
			<ul class="list-group">
				<?php if (count($eventList->getItems()) == 0) { ?>
					<li class="list-group-item">Tidak ada event</li>
				<?php } else { ?>
				<?php foreach($eventList->getItems() as $event){ ?>
					<a href="<?php echo $event->htmlLink ?>" class="list-group-item">
						<span class="badge">
							<?php 
							echo empty($event->start->dateTime) ? $event->start->date : $event->start->dateTime;
							echo ' / ';
							echo empty($event->end->dateTime) ? $event->end->date : $event->end->dateTime;
							?>
						</span>
						<?php echo $event->getSummary() ?>
					</a>
				<?php } }?>
			</ul>
		</div>

        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        <!-- jQuery 2.2.4 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
		<!-- Bootstrap 3.3.6 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>
</html>
