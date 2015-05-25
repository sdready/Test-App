<?php
include '/srv/www/test_app/shared/config/opsworks.php'; 

/*
  $db_host = 'test-rds.cpnv7me8ryeg.us-east-1.rds.amazonaws.com';
  $db_username = 'shaun';
  $db_password = 'Virmire-209';
  $db_name = "test_db_2";
*/

  $db_host = $host;
  $db_username = $username;
  $db_password = $password;
  $db_name = $database;

  $db = new mysqli($db_host, $db_username, $db_password, $db_name);

  if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
  }

  $sectionName = "Acute Care";

  $result = $db->query("SELECT ID
                        FROM Sections
                        WHERE Name = '" . $sectionName . "'");

  $sectionID = (int)$result->fetch_assoc()['ID'];


  $sections = $db->query("  SELECT *
                            FROM Sections
                         ");

  $subSections = $db->query(" SELECT s.*, sr.*
                              FROM Sections s
                                INNER JOIN SectionRelationships sr ON s.ID = sr.ChildSectionID
                              WHERE sr.SectionID = " . $sectionID
                            );


  $events = $db->query("  SELECT *
                          FROM " . str_replace(' ', '', $sectionName) . "Events
                      ");
?>





<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TactiCal Test</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/dashboard/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>



    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">TactiCal</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>



    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="#" data-toggle="collapse">Reports</a></li>
            <li><a href="#">Analytics</a></li>
          </ul>
          <br />
          <h4>Sections</h4>
          <ul class="nav nav-stacked" id="accordion1">
            <li>
              <div class="row"><button class='btn btn-default btn-xs' data-toggle="collapse" data-parent="#accordion1" href="#firstLink">
                <span class='glyphicon glyphicon-plus' onclick='collapseIcon(this)'></span></button>
                <a href="" style="padding-left: 8px"><?php echo $sectionName;?></a>
              </div>
              <ul id="firstLink" class="collapse">
                  <?php
                    foreach ($subSections as $subSection) {
                      echo '<li>' . $subSection['Name'] . '</li>';
                    }
                  ?>
              </ul>
            </li>
        </ul>
        </div>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>


<div class="col-lg-9">
  <div class="panel panel-default">
    <div class="panel-heading"><h3>Events</h3></div>
    <div class="panel-body">
      <table class="table table-condensed" style="border-collapse:collapse;">

        <tbody>
          <?php
          $i = 0;
            foreach ($events as $row) {
              echo "<tr data-toggle='collapse' data-target='#test" . $i . "' class='accordion-toggle'>
                      <td><button class='btn btn-default btn-xs'><span class='glyphicon glyphicon-plus' onclick='collapseIcon(this)'></span></button></td>
                      <td>" . $row['EventName'] . "</td>
                    </tr>
                    <tr>
                      <td colspan='12' class='hiddenRow'><div class='accordian-body collapse' id='test" . $i++ . "'> 
                        <table class='table table-striped'>
                          <thead>
                            <tr><td><a href='WorkloadURL'>Workload link</a></td><td>Bandwidth: Dandwidth Details</td><td>OBS Endpoint: end point</td></tr>
                            <tr><th>Access Key</th><th>Secret Key</th><th>Status </th><th> Created</th><th> Expires</th><th>Actions</th></tr>
                          </thead>
                          <tbody>
                            <tr><td>access-key-1</td><td>secretKey-1</td><td>Status</td><td>some date</td><td>some date</td><td><a href='#' class='btn btn-default btn-sm'>
                            <i class='glyphicon glyphicon-cog'></i></a></td></tr>
                          </tbody>
                        </table>            
                      </div></td>
                    </tr>";                  
            }
          ?>

        </tbody>
      </table>
    </div>
  </div> 
</div>

<script type="text/javascript">

  function collapseIcon(element) {
    $(element).toggleClass('glyphicon-plus');
    $(element).toggleClass('glyphicon-minus');
  }

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
<script src="http://getbootstrap.com/assets/js/vendor/holder.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>