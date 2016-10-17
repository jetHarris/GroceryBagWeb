<html>
<head>
    <meta http-equiv="pragma" content="no-cache" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet"/>

    <script src="scripts/jquery-3.1.0.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
    <script src="scripts/grocerybag.js"> </script>
    <title>
        Grocery Bag
    </title>
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
                <!--<li class="active"><a href="#">Home</a></li>-->
                <li class="active"><a href="index.php">Item Bank</a></li>
                <li><a href="list.php">List</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container" id="body-container">


<div id="mainContainer">
    <div>
        <h3 id="update_msg"><?php require ("Connection.php");
            if (isset($_POST['delete_item_bank_item']))
            {
                $id = $_POST['item_id'];
                $checkIfDeletable = "SELECT COUNT(*) FROM grocerylist.listitems WHERE itemid = $id";
                $check = mysqli_query($conn, $checkIfDeletable);
                $row = mysqli_fetch_assoc($check);
                $count = intval($row["COUNT(*)"]);

                if($count !== 0)
                {
                    $msg = "Unable to delete, item is in use!";
                }
                else
                {
                    $sql = "DELETE FROM grocerylist.items WHERE id = $id;";
                    if ($conn->query($sql) === TRUE) {
                            $msg = "Item deleted!";
                    }
                    else{
                        $msg = "Item not deleted! ".$conn->error;
                    }
                }

            }

            else if (isset($_POST['item_name'])){
                $new_item_name = $_POST['item_name'];
                $new_price = floatval((str_replace('$', '',$_POST['price'] )));
                $new_sale_price = floatval((str_replace('$', '',$_POST['sales_price'] )));
                $on_sale = isset($_POST['on_sale']) ? 1:0;
                $has_GST = isset($_POST['gst']) ? 1:0;
                $has_PST = isset($_POST['pst']) ? 1:0;
                $has_HST = isset($_POST['hst']) ? 1:0;
                $id = $_POST['item_id'];
                if ($id === '-1'){
                    $queryToRun = "INSERT INTO Items (item_name, price, sale_price, use_sale_price, GST, PST, HST) VALUES ('$new_item_name', $new_price, $new_sale_price, $on_sale, $has_GST, $has_PST, $has_HST)";
                }
                else {
                    $queryToRun = "UPDATE Items SET item_name = '$new_item_name', price = $new_price, sale_price = $new_sale_price, use_sale_price=$on_sale, GST=$has_GST, PST=$has_PST, HST=$has_HST WHERE id=$id;";
                }
                if ($conn->query($queryToRun) === TRUE) {
                    if ($id === '-1')
                        $msg = "Item added!";
                    else
                        $msg = "Item updated successfully!";
                }
                else {
                    if ($id === '-1')
                        $msg = "Error adding item: ". $conn->error;
                    else
                        $msg =  "Error updating item: " . $conn->error;
                }
            }
            echo $msg ?></h3>
    </div>
    <div id="itemBankList">
        <div>
                <input type="text" id="filter" onkeyup="filterInput(this)" placeholder="Filter"/>
        </div>
<?php require ("Connection.php");
session_start();
//$userID = $_SESSION['userID'];   //until we have the code to grab it.
//Err $_SESSION['userID'] = $userID;


$name = $_SESSION['name'];
echo "Welcome ".$name."!";

$sql= "SELECT i.*, (SELECT COUNT(*) FROM grocerylist.listitems WHERE itemid = i.id) as Count FROM grocerylist.items as i;";
$check = mysqli_query($conn, $sql);

$output = '<table border="1"><thead><tr id="not-header"><th class="id">ID</th>'.
    '<th class="item">Item</th>'.
    '<th class="price">Price</th>'.
    '<th class="sale-price">Sale Price</th>'.
    '<th class="checkmark">On Sale</th>'.
    '<th class="checkmarktax">GST</th>'.
    '<th class="checkmarktax">PST</th>'.
    '<th class="checkmarktax">HST</th></tr></thead></table><div id="itemBank" style="height:75%; overflow-y: auto; display: inline-block;"><table border="1" style="height: auto; maring-bottom: 0px;padding-bottom: 0px;">';

while($row = mysqli_fetch_assoc($check)){
    $output .='<tr class="highlight" onclick="rowClicked(this)">';
    $output .= '<td class="id">'.$row['id'].'</td>';
    $output .= '<td class="item">'.$row['item_name'].'</td>';
    $output .= '<td class="price">$'.$row['price'].'</td>';
    $output .= '<td class="sale-price">$'.$row['sale_price'].'</td>';
    $output .= '<td class="checkmark">'.($row['use_sale_price'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .= '<td class="checkmarktax">'.($row['GST'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .= '<td class="checkmarktax">'.($row['PST'] === '1' ? '&#9989;':'&#10008;').'</td>';
    $output .= '<td class="checkmarktax">'.($row['HST'] === '1' ? '&#9989;':'&#10008;').'</td>';

    if ($row['Count'] == 0)
        $output .= '<td class="hidden-cell">yes</td>';
    else
        $output .= '<td class="hidden-cell">no</td>';
    $output .='</tr>';
}
$output .='</tbody></table></div>';
echo $output;
?>
        <div>
            <input type="button" value="Create Item" class="button" onclick="createItemClick();" style="margin-bottom: 30px"/>
        </div>
    </div>

<div id="editItemBankForm" style="display:none;">
    <form action="index.php" method="post" id="edit_item_form">
    <div style="display:block; float:left; width:40%; padding-top:0px;">
        <div>
            <h3 id="item_id_div"></h3>
        </div>
        <div>
            <input type="text" id="name_input" name="item_name" placeholder="Item Name"/>
        </div>
        <div>
            <input type="text" id="price_input" name="price" placeholder="Price" />
        </div>
        <div>
            <input type="text" id="sale_price_input" name="sales_price" placeholder="Sales Price" />
        </div>
    </div>
    <div style="display:block; float:right; width:60%;padding-top:20px;">
        <div>
            <label>On Sale:</label>
            <input type="checkbox" name="on_sale" id="on_sale_input"/>
        </div>
        <div>
            <label>GST:</label>
            <input type="checkbox" name="gst" id ="gst_input"/>
        </div>
        <div>
            <label>PST:</label>
            <input type="checkbox" name="pst" id = "pst_input"/>
        </div>
        <div>
            <label>HST:</label>
            <input type="checkbox" name="hst" id ="hst_input" />
        </div>
    </div>
        <div style="clear:both;">
            <input type="submit" value="Save" id="update_item" name="update_item" style="display: none;"/>
            <input type="submit" value="Add" id="add_item" name="add_item" class="button" style="display: none;"/>
            <input type="button" value="Cancel" class="button" onclick="cancelClick();"/>
            <input type="submit" value="Delete" id="DeleteItemBankItem" name="delete_item_bank_item"/>
            <input type="hidden" value="-1" id="selected_item_id" name="item_id"/>
        </div>
    </form>
</div>
</div>
</div>
</body>
</html>




