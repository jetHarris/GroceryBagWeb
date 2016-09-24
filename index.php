<html>
<head>
    <meta http-equiv="pragma" content="no-cache" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet"/>

    <script src="scripts/jquery-3.1.0.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
    <script src="scripts/grocerybag.js"> </script>
    <title>Grocery Bag</title>
</head>
<body onload="setup();">
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#"><img src="img/baglogo.png" id="logo" width="150"/></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
<div>
        <input type="text" id="filter" onkeyup="filterInput(this)" placeholder="Find"/>
</div>
<div class="table-container">


<?php require ("Connection.php");

$sql= "SELECT * from grocerylist.items;";
$check = mysqli_query($conn, $sql);

$output =
    '<table border="1">
        <thead><tr id="not-header"><th class="id">ID</th>'.
            '<th class="item">Item</th>'.
            '<th class="price">Price</th>'.
            '<th class="sale-price">Sale Price</th>'.
            '<th class="checkmark">Sale</th>'.
            '<th class="checkmarktax">GST</th>'.
            '<th class="checkmarktax">PST</th>'.
            '<th class="checkmarktax">HST</th><!--'.
    '<th id="th-spacer"></th>--></tr>
        </thead>
    </table>
<div id="itemBank" style="height:100%; overflow-y: auto; display: inline-block;">
<table border="1" style="height: auto;">';

while($row = mysqli_fetch_assoc($check)){
    $output .='<tr>';
    $output .= '<td class="id">'.$row['id'].'</td>';
    $output .= '<td class="item">'.$row['item_name'].'</td>';
    $output .= '<td class="price">$'.$row['price'].'</td>';
    $output .= '<td class="sale-price">$'.$row['sale_price'].'</td>';
    $output .= '<td  class="checkmark">'.($row['use_sale_price'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .= '<td class="checkmarktax">'.($row['GST'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .= '<td class="checkmarktax">'.($row['PST'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .= '<td class="checkmarktax">'.($row['HST'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .='</tr>';
}
$output .='</tbody></table></div>';
echo $output;
?>

</div>
</div>
<div id="blank"></div>
</body>
</html>




