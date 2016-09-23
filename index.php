<html>
<head>
    <meta http-equiv="pragma" content="no-cache" />
    <link href="css/style.css" rel="stylesheet"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <script src="scripts/jquery-3.1.0.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
    <script src="scripts/grocerybag.js"> </script>
    <title>
        Grocery Bag
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
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
<img src="img/baglogo.jpg" width="300px" height="200px"/>

<div id="mainContainer">
    <div id="itemBankList">
        <div>
            <p>Filter:
                <input type="text" id="filter" onkeyup="filterInput(this)"/></p>
        </div>
<?php require ("Connection.php");

$sql= "SELECT * from grocerylist.items;";
$check = mysqli_query($conn, $sql);

$output = '<table border="1"><thead><tr><th class="id">ID</th>'.
    '<th class="item">Item</th>'.
    '<th class="price">Price</th>'.
    '<th class="price">Sale Price</th>'.
    '<th class="checkmark">On Sale</th>'.
    '<th class="checkmarktax">GST</th>'.
    '<th class="checkmarktax">PST</th>'.
    '<th class="checkmarktax">HST</th></tr></thead></table><div id="itemBank" style="height:100px; overflow-y: auto; display: inline-block;"><table border="1">';

while($row = mysqli_fetch_assoc($check)){
    $output .='<tr class="highlight" onclick="rowClicked(this)">';
    $output .= '<td class="id">'.$row['id'].'</td>';
    $output .= '<td class="item">'.$row['item_name'].'</td>';
    $output .= '<td class="price">$'.$row['price'].'</td>';
    $output .= '<td class="price">$'.$row['sale_price'].'</td>';
    $output .= '<td class="checkmark">'.($row['use_sale_price'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .= '<td class="checkmarktax">'.($row['GST'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .= '<td class="checkmarktax">'.($row['PST'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .= '<td class="checkmarktax">'.($row['HST'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .='</tr>';
}
$output .='</tbody></table></div>';
echo $output;
?>
    </div>

<div id="editItemBankForm" style="display:none;">
    <form action="/edit-item" method="post" id="edit_item_form">
        <div>
            <h3 id="item_id_div"></h3>
        </div>
        <div>
            <label for="name">Item Name:</label>
            <input type="text" id="name_input" name="item_name" />
        </div>
        <div>
            <label for="mail">Price:</label>
            <input type="text" id="price_input" name="price" />
        </div>
        <div>
            <label for="msg">Sales Price:</label>
            <input type="text" id="sale_price_input" name="sales_price" />
        </div>
        <div>
            <label for="msg">On Sale:</label>
            <input type="checkbox" name="on_sale" id="on_sale_input"/>
        </div>
        <div>
            <label for="msg">GST:</label>
            <input type="checkbox" name="gst" id ="gst_input"/>
        </div>
        <div>
            <label for="msg">PST:</label>
            <input type="checkbox" name="pst" id = "pst_input"/>
        </div>
        <div>
            <label for="msg">HST:</label>
            <input type="checkbox" name="hst" id ="hst_input" />
        </div>
        <div>
            <input type="submit" value="Save"/>
            <input type="button" value="Cancel" onclick="cancelClick();"/>
        </div>
    </form>
</div>
</div>
</div>
</body>
</html>




