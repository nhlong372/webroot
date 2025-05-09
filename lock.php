<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Notification</title>
    <meta name="robots" content="noindex,nofollow" />
    <link href="assets/coming/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="assets/coming/css/clock.css" rel="stylesheet" type="text/css" media="all" />
    <link href='http://fonts.googleapis.com/css?family=Petit+Formal+Script' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:300,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300' rel='stylesheet' type='text/css'>
    <script src="assets/js/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Create two variable with the names of the months and days in an array
            var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]

            // Create a newDate() object
            var newDate = new Date();
            // Extract the current date from Date object
            newDate.setDate(newDate.getDate());
            // Output the day, date, month and year    
            $('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

            setInterval(function() {
                // Create a newDate() object and extract the seconds of the current time on the visitor's
                var seconds = new Date().getSeconds();
                // Add a leading zero to seconds value
                $("#sec").html((seconds < 10 ? "0" : "") + seconds);
            }, 1000);

            setInterval(function() {
                // Create a newDate() object and extract the minutes of the current time on the visitor's
                var minutes = new Date().getMinutes();
                // Add a leading zero to the minutes value
                $("#min").html((minutes < 10 ? "0" : "") + minutes);
            }, 1000);

            setInterval(function() {
                // Create a newDate() object and extract the hours of the current time on the visitor's
                var hours = new Date().getHours();
                // Add a leading zero to the hours value
                $("#hours").html((hours < 10 ? "0" : "") + hours);
            }, 1000);

        });
    </script>
</head>

<body>
    <div class="content">
        <div class="wrap">
            <div class="content-grid">
                <p><img src="assets/coming/images/top.png" title=""></p>
            </div>
            <div class="grid">
                <p><img src="assets/coming/images/coming.png" title=""></p>
                <h3>We are Still Working on it.</h3>
                <div class="clock">
                    <ul>
                        <li id="hours"></li>
                        <li id="point">:</li>
                        <li id="min"></li>
                        <li id="point">:</li>
                        <li id="sec"></li>
                    </ul>
                    <div id="Date"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <p style="text-align: center;"><a href="index.php" title="Trial" style="color: #fff; ">Trial</a></p>
        </div>
    </div>
    <div class="clear"></div>
</body>

</html>