<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>@yield('title', 'Equipment')</title>

    <!-- Bootstrap -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">
    <link href="/css/treeview.css" rel="stylesheet">
    <link href="/assets/css/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="/assets/jquery-ui/jquery-ui.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/pivot-table/dist/pivot.css">
    @yield('css')

	<?php 
//phpinfo();
?>
<?php
//    $mysqli = mysqli_connect("localhost", "root", "stewart", "holtT3");
//	echo $mysqli;	
//echo mysqli_error();
//	$results = mysqli_query($mysqli, "select * from users");
//	$row = mysqli_fetch_array($results);
//	echo $row['first_name'];
//$result = $mysqli->query("SELECT lastname FROM employees");
?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{{ asset('uploads/favicon.ico') }}}">
    <!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Scripts -->
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
  </head>
