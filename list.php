<html>
<head>
    <meta http-equiv="pragma" content="no-cache" />
    <link href="css/style.css" rel="stylesheet"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <script src="scripts/jquery-3.1.0.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
    <script src="scripts/grocerybag.js"> </script>
    <title>
        Grocery Bag List
    </title>
</head>
<body onload="setup();">
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
				<li class="active"><a href="#">List</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
<div>
<?php require ("Connection.php");

$sql= "SELECT list_name FROM grocerylist.Lists WHERE id = 1;";
$check = mysqli_query($conn, $sql);
$output ='';
while($row = mysqli_fetch_assoc($check)){
	$output .= '<p>'.$row['list_name'].'</p>';
}

echo $output;
?>

</div>
<div>
<?php require ("Connection.php");

$sql= "SELECT i.id, i.item_name,i.price,i.sale_price,i.use_sale_price,i.GST,i.PST,i.HST, li.quantity
FROM grocerylist.items as i
INNER JOIN grocerylist.listitems as li
    ON i.id = li.itemID
INNER JOIN grocerylist.lists as l
    ON li.listID = l.id
WHERE l.id = 1;";
$check = mysqli_query($conn, $sql);

$total_price = 0;

$output = '<table border="1"><thead><tr><th class="id">ID</th>'.
    '<th class="item">Item</th>'.
    '<th class="price">Price</th>'.
    '<th class="price">Sale Price</th>'.
    '<th class="checkmark">On Sale</th>'.
    '<th class="checkmarktax">GST</th>'.
    '<th class="checkmarktax">PST</th>'.
    '<th class="checkmarktax">HST</th>'.
	'<th class="item">Quantity</th></tr></thead></table><div id="itemBank" style="height:100px; overflow-y: auto; display: inline-block;"><table border="1">';

while($row = mysqli_fetch_assoc($check)){
    $output .='<tr class="highlight">';
    $output .= '<td class="id">'.$row['id'].'</td>';
    $output .= '<td class="item">'.$row['item_name'].'</td>';
    $output .= '<td class="price" contenteditable="true">$'.$row['price'].'</td>';
    $output .= '<td class="price" contenteditable="true">$'.$row['sale_price'].'</td>';
    $output .= '<td class="checkmark" contenteditable="true">'.($row['use_sale_price'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .= '<td class="checkmarktax" contenteditable="true">'.($row['GST'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .= '<td class="checkmarktax" contenteditable="true">'.($row['PST'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .= '<td class="checkmarktax" contenteditable="true">'.($row['HST'] === '1' ? '&#9989;':'&#10008;').'</td>';
	$output .= '<td class="item" contenteditable="true">'.$row['quantity'].'</td>';
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




