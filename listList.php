<?php
 session_start();
?>
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
                <li class="active"><a href="listlist.php">List</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container" id="main-container">

    <div>
        <h3 id="update_msg"><?php require ("Connection.php");
            if (isset($_POST['nameList_input']) && $_POST['nameList_input'] != "" ) {
                $listName = $_POST['nameList_input'];
                $budget = floatval((str_replace('$', '',$_POST['budget_input'] )));
                $owner = $_SESSION['user_id'];
                $listItem_ID = $_POST['listItemId'];


                if($listItem_ID == -1)
                    $update = "INSERT INTO lists (list_name,budget,list_owner_id) VALUES ('".$listName."'," .  $budget .",".$owner.")";
                else
                    $update = "UPDATE Lists SET list_name = '$listName',budget=$budget WHERE id=$listItem_ID";

                if($conn->query($update))
                    $msg = "Item(s) Added ";
            }
//                if ($_POST['adding'] != '')
//                {
//                    if($_POST['adding'] != "stop") {
//                        $pieces = explode(" ", $_POST['adding']);
//                        foreach ($pieces as &$value) {
//                            if ($value != '') {
//                                $update = "INSERT INTO listitems (quantity,itemId,listID) VALUES (1," . $value . ",$list_id)";
//                                //var_dump($update);
//                                $conn->query($update);
//                            }
//                        }
//                        $msg = "Item(s) Added ";
//                    }
//                    $_POST['adding'] = "stop";
//                }
//                else {
//
//
//                    $new_item_name = $_POST['item_name'];
//                    $new_price = floatval((str_replace('$', '', $_POST['price'])));
//                    $new_sale_price = floatval((str_replace('$', '', $_POST['sales_price'])));
//                    $on_sale = isset($_POST['on_sale']) ? 1 : 0;
//                    $has_GST = isset($_POST['gst']) ? 1 : 0;
//                    $has_PST = isset($_POST['pst']) ? 1 : 0;
//                    $has_HST = isset($_POST['hst']) ? 1 : 0;
//                    $id = $_POST['item_id'];
//                    $second_update ="";
//                    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
//                    if ($_POST['delete'] != "yes") {
//                        $update = "UPDATE Items SET item_name = '$new_item_name', price = $new_price,
//                        sale_price = $new_sale_price, use_sale_price=$on_sale, GST=$has_GST, PST=$has_PST, HST=$has_HST
//                        WHERE id=$id;";
//                        if(isset($_POST['quantity'])) {
//                            $second_update = "UPDATE listitems SET quantity = $quantity WHERE listID = $list_id AND itemID = $id;";
//                        }
//                    } else {
//                        $deleted = true;
//                        $update = "DELETE FROM listitems WHERE itemID=$id;";
//                    }
//                    if (!$deleted && $conn->query($update) === TRUE) {
//                        $msg = "Item updated successfully!";
//                        if($second_update != "")
//                            $conn->query($second_update);
//                    } else if ($deleted && $conn->query($update) === TRUE) {
//                        $msg = "Item removed from list!";
//                    } else {
//                        $msg = "Error updating item: " . $conn->error;
//                    }
//                }
//            }
//            else if (isset($_POST['id_i']))
//            {
//
//                $id = $_POST['id_i'];
//                if($_POST['checking'] == "checked")
//                {
//                    $updateC = "UPDATE listitems SET checked = 1 WHERE listID = $list_id AND itemID = $id;";
//                    $conn->query($updateC);
//                }
//                else if ($_POST['checking'] == "unchecked"){
//                    $updateC = "UPDATE listitems SET checked = 0 WHERE listID = $list_id AND itemID = $id;";
//                    $conn->query($updateC);
//                }
//            }


            echo $msg ?></h3>
    </div>
    <div id="table-list">
        <?php require ("Connection.php");
        $list_id;
        $user_id = $_SESSION['user_id'];



        $sql= "SELECT * FROM grocerylist.Lists WHERE list_owner_id = $user_id;";
        $check = mysqli_query($conn, $sql);
        $output ='';


        $sub_total = 0;
        $total_tax = 0;

        $output = '<table border="1"><thead><tr><th class="id">ID</th>'.
            '<th class="item">List Name</th>'.
            '<th class="price">Budget</th>'.
            '<th class="price">Owner</th>'.
            '</tr></thead></table><div id="itemBank" style="height:100px; overflow-y: auto; display: inline-block;"><table border="1">';

        while($row = mysqli_fetch_assoc($check)){
            var_dump($row['checked']=== '1');
            $output .='<tr class="highlight">';
            $output .= '<td class="id" onclick="editListListId(this)">'.$row['id'].'</td>';
            $output .= '<td class="item" onclick="rowClickedListList(this)">'.$row['list_name'].'</td>';
            $output .= '<td class="price" onclick="rowClickedListList(this)">$'.$row['budget'].'</td>';
            $output .= '<td class="price" onclick="rowClickedListList(this)">'.$row['list_owner_id'].'</td>';
            $output .='</tr>';


        }
        $output .='</tbody></table></div>';
        echo $output;
        ?>
        <input type="button" value="Create new lists" onclick="addViewListClick();"/>

    </div>
</div>
<div id="addItemListForm" style="display:none;">
    <form action="listlist.php" method="post" id="add_item_form">
        <div>
            <h3 id="item_id_div"></h3>
        </div>
        <div>
            <label>List Name:</label>
            <input type="text" id="nameList_input" name="nameList_input" />
        </div>
        <div>
            <label>Budget:</label>
            <input type="text" id="budget_input" name="budget_input" />
        </div>

        <div>
            <input type="submit" value="Save" id="submit-button"/>
            <input type="button" value="Cancel" onclick="cancelListListClick();"/>
            <input type="hidden" value="-1" id="listItemId" name="listItemId"/>
        </div>
    </form>
</div>
<div id="blank"></div>
</body>
</html>




