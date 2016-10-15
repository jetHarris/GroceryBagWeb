<html>
<head>
    <meta http-equiv="pragma" content="no-cache" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet"/>

    <script src="scripts/jquery-3.1.0.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
    <script src="scripts/grocerybag.js"> </script>
    <title>
        Grocery Bag List
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
                <li><a href="index.php">Item Bank</a></li>
                <li class="active"><a href="list.php">List</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container" id="main-container">
<div>
    <?php require ("Connection.php");


    $sql= "SELECT list_name FROM grocerylist.Lists WHERE id = 1;";
    $check = mysqli_query($conn, $sql);
    $output ='';
    while($row = mysqli_fetch_assoc($check)){
        $output .= '<h3>'.$row['list_name'].'</h3>';
    }

    echo $output;
    ?>

    </div>
    <div>
        <h3 id="update_msg"><?php require ("Connection.php");
            if (isset($_POST['item_name'])){
                if ($_POST['adding'] != '')
                {
                    if($_POST['adding'] != "stop") {
                        $pieces = explode(" ", $_POST['adding']);
                        foreach ($pieces as &$value) {
                            if ($value != '') {
                                $update = "INSERT INTO listitems (quantity,itemId,listID) VALUES (1," . $value . ",1)";
                                //var_dump($update);
                                $conn->query($update);
                            }
                        }
                        $msg = "Item(s) Added ";
                    }
                    $_POST['adding'] = "stop";
                }
                else {


                    $new_item_name = $_POST['item_name'];
                    $new_price = floatval((str_replace('$', '', $_POST['price'])));
                    $new_sale_price = floatval((str_replace('$', '', $_POST['sales_price'])));
                    $on_sale = isset($_POST['on_sale']) ? 1 : 0;
                    $has_GST = isset($_POST['gst']) ? 1 : 0;
                    $has_PST = isset($_POST['pst']) ? 1 : 0;
                    $has_HST = isset($_POST['hst']) ? 1 : 0;
                    $id = $_POST['item_id'];
                    $second_update ="";
                    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
                    if ($_POST['delete'] != "yes") {
                        $update = "UPDATE Items SET item_name = '$new_item_name', price = $new_price,
                        sale_price = $new_sale_price, use_sale_price=$on_sale, GST=$has_GST, PST=$has_PST, HST=$has_HST
                        WHERE id=$id;";
                        if(isset($_POST['quantity'])) {
                            $second_update = "UPDATE listitems SET quantity = $quantity WHERE listID = 1 AND itemID = $id;";
                        }
                    } else {
                        $deleted = true;
                        $update = "DELETE FROM listitems WHERE itemID=$id;";
                    }
                    if (!$deleted && $conn->query($update) === TRUE) {
                        $msg = "Item updated successfully!";
                        if($second_update != "")
                            $conn->query($second_update);
                    } else if ($deleted && $conn->query($update) === TRUE) {
                        $msg = "Item removed from list!";
                    } else {
                        $msg = "Error updating item: " . $conn->error;
                    }
                }
            }


            echo $msg ?></h3>
    </div>
    <div id="table-list">
        <?php require ("Connection.php");

        $sql= "SELECT i.id, i.item_name,i.price,i.sale_price,i.use_sale_price,i.GST,i.PST,i.HST, li.quantity
    FROM grocerylist.items as i
    INNER JOIN grocerylist.listitems as li
        ON i.id = li.itemID
    INNER JOIN grocerylist.lists as l
        ON li.listID = l.id
    WHERE l.id = 1;";
        $check = mysqli_query($conn, $sql);

        $sub_total = 0;
        $total_tax = 0;

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
            $output .='<tr class="highlight" onclick="rowClickedList(this)">';
            $output .= '<td class="id">'.$row['id'].'</td>';
            $output .= '<td class="item">'.$row['item_name'].'</td>';
            $output .= '<td class="price">$'.$row['price'].'</td>';
            $output .= '<td class="price">$'.$row['sale_price'].'</td>';
            $output .= '<td class="checkmark">'.($row['use_sale_price'] === '1' ? '&#9989;':'&#10008;').'</td>';
            $output .= '<td class="checkmarktax">'.($row['GST'] === '1' ? '&#9989;':'&#10008;').'</td>';
            $output .= '<td class="checkmarktax">'.($row['PST'] === '1' ? '&#9989;':'&#10008;').'</td>';
            $output .= '<td class="checkmarktax">'.($row['HST'] === '1' ? '&#9989;':'&#10008;').'</td>';
            $output .= '<td class="item">'.$row['quantity'].'</td>';
            $output .='</tr>';

            $getTaxes= "SELECT GST, PST, HST FROM WHERE id = 1";
            $result = mysqli_query($sql);
            $gst =0.0;
            $pst = 0.0;
            $hst = 0.0;

            $result1 = mysqli_query($conn, $getTaxes);
            $row2 = mysqli_fetch_assoc($result1);

            $gst =$row['GST'];
            $pst = $row['PST'];
            $hst =$row['HST'];

            $tax = 0;
            if($row['GST'] === '1')
                $tax += 0.05;
            if($row['PST'] === '1')
                $tax += 0.08;
            if($row['HST'] === '1')
                $tax += 0.13;

            if ($row['use_sale_price'] === '1') {
                $sub_total += floatval($row['sale_price']) * floatval($row['quantity']);
                $total_tax += (floatval($row['sale_price']) * floatval($row['quantity']))*$tax;
            }
            else {
                $sub_total += floatval($row['price']) * floatval($row['quantity']);
                $total_tax += (floatval($row['price']) * floatval($row['quantity']))*$tax;
            }

            $tax = 0;

        }
        $output .='</tbody></table></div>';
        echo $output;
        ?>
        <input type="button" value="Add additional items" onclick="addViewClick();"/>

        <div>Subtotal: $<?php  echo number_format((float)$sub_total, 2, '.', ''); ?></div>
        <div>Taxes: $<?php  echo number_format((float)$total_tax, 2, '.', ''); ?></div>
        <?php $total = $total_tax + $sub_total ?>
        <div>Total Price: $<?php  echo number_format((float)$total, 2, '.', ''); ?></div>
    </div>
</div>
<div id="editItemListForm" style="display:none;">
    <form action="list.php" method="post" id="edit_item_form">
        <div>
            <h3 id="item_id_div"></h3>
        </div>
        <div>
            <label>Item Name:</label>
            <input type="text" id="name_input" name="item_name" />
        </div>
        <div>
            <label>Price:</label>
            <input type="text" id="price_input" name="price" />
        </div>
        <div>
            <label>Sales Price:</label>
            <input type="text" id="sale_price_input" name="sales_price" />
        </div>
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
        <div>
            <label>Quantity:</label>
            <input type="text" name="quantity" id ="quantity_input" />
        </div>
        <div style="display:none">
            <label >Delete:</label>
            <input type="text" name="delete" id ="delete_input" />
        </div>
        <div style="display:none">
            <label >Adding:</label>
            <input type="text" name="adding" id ="adding_input" value='' />
        </div>
        <div>
            <input type="submit" value="Save" id="submit-button"/>
            <input type="button" value="Cancel" onclick="cancelListClick();"/>
            <input type="button" value="Remove" onclick="removeClick();"/>
            <input type="hidden" value="-1" id="selected_item_id" name="item_id"/>
        </div>
    </form>
</div>
<div id="addItemForm" style="display:none;">

    <form action="list.php" method="post" id="add_item_form">
        <?php require ("Connection.php");

        //JF I think this query works a bit better?
        $sql = "SELECT i.id, i.item_name, i.price,i.use_sale_price,i.GST,i.PST,i.HST FROM grocerylist.items as i
        WHERE NOT EXISTS (SELECT li.listid FROM grocerylist.listitems as li WHERE li.listid = 1 AND
        li.itemID = i.id);";

        /*$sql ="SELECT DISTINCT i.id, i.item_name, i.price,i.use_sale_price,i.GST,i.PST,i.HST
FROM grocerylist.items as i
LEFT JOIN grocerylist.listitems
ON i.id=grocerylist.listitems.itemID
WHERE grocerylist.listitems.listID IS NULL OR grocerylist.listitems.listID !=1";*/

//        $sql= "SELECT i.id, i.item_name,i.price,i.sale_price,i.use_sale_price,i.GST,i.PST,i.HST, li.quantity
//    FROM grocerylist.items as i
//    INNER JOIN grocerylist.listitems as li
//        ON i.id = li.itemID
//    INNER JOIN grocerylist.lists as l
//        ON li.listID = l.id
//    WHERE l.id != 1;";
        $check = mysqli_query($conn, $sql);

        $output = '';

        while($row = mysqli_fetch_assoc($check)){
            $output .='<div>';
            $output .= '<label id="'.$row['id'].'">'.$row['item_name'].'<input type="checkbox" id="'.$row['id'].'" onchange="toggleCheckbox(this)"></input></label>';
            $output .= '</div>';
        }
        echo $output;
        ?>
        <input type="button" value="Add Items" id="submit-button" class="button" onclick="addItemClick();"/>
    </form>
</div>
<div id="blank"></div>
</body>
</html>




