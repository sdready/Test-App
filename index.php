<?php

  $db_host = 'test-rds.cpnv7me8ryeg.us-east-1.rds.amazonaws.com';
  $db_username = 'shaun';
  $db_password = 'Virmire-209';
  $db_table = "test_db_2";

  $db = new mysqli($db_host, $db_username, $db_password, $db_table);

  if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
  }

  $sectionName = "Acute Care";

  $result = $db->query("SELECT ID
                        FROM Sections
                        WHERE Name = '" . $sectionName . "'");

  $sectionID = (int)$result->fetch_assoc()['ID'];

  $subSections = $db->query(" SELECT s.*, sr.*
                              FROM Sections s
                                INNER JOIN SectionRelationships sr ON s.ID = sr.RelativeSectionID
                              WHERE sr.SectionID = " . $sectionID . " AND sr.RelativeIsChild = 1
                            ");

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



          
          
<div class="col-lg-6">
  <div class="panel panel-default">
    <div class="panel-heading"><h3>Sub Sections</h3></div>
    <div class="panel-body">
      <table class="table table-condensed" style="border-collapse:collapse;">

        <thead>
          <tr><th>&nbsp;</th>
            <th>Sub Section</th>
            <th>Description</th>
          </tr>
        </thead>

        <tbody>
          <?php
            $i = 0;
            foreach ($subSections as $row) {
              echo "<tr data-toggle='collapse' data-target='#test" . $i . "' class='accordion-toggle'>
                      <td><button class='btn btn-default btn-xs'><span class='glyphicon glyphicon-eye-open'></span></button></td>
                      <td>" . $row['Name'] . "</td>
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

<div class="col-lg-6">
  <div class="panel panel-default">
    <div class="panel-heading"><h3>Events</h3></div>
    <div class="panel-body">
      <table class="table table-condensed" style="border-collapse:collapse;">

        <thead>
          <tr><th>&nbsp;</th>
            <th>Sub Section</th>
            <th>Description</th>
          </tr>
        </thead>

        <tbody>
          <?php
            foreach ($events as $row) {
              echo "<tr data-toggle='collapse' data-target='#test" . $i . "' class='accordion-toggle'>
                      <td><button class='btn btn-default btn-xs'><span class='glyphicon glyphicon-eye-open'></span></button></td>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
<script src="http://getbootstrap.com/assets/js/vendor/holder.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>