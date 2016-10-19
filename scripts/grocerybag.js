var grocerybag = {
    originalData : ''
};

function setup(){
    grocerybag.originalData = $('#itemBank')[0].innerHTML;
}

function filterInput(filter){
    var filterObj = $(filter);
    var newTable = '';
    if (filterObj[0].value.length === 0)
    {
        newTable = grocerybag.originalData;
    }
    else
    {
        //create a jQuery object from our stored data
        //var html = $($.parseHTML(grocerybag.originalData));
        var html = $(grocerybag.originalData);
        html.find("tr").each(function(i, el){
            var cells = $(el).find("td");
            var cellText = cells[1].innerHTML.toLowerCase();
            var textBox = filterObj[0].value.toLowerCase();

            var idx = cellText.indexOf(textBox);
            if (idx === -1 )
                el.remove();
            /*var p = document.createElement("p");
             p.appendChild(document.createTextNode(el.nodeName));
             document.getElementById("blank").appendChild(p);

             document.getElementById("blank").appendChild(document.createElement("br"));*/
        });
        newTable = html[0].outerHTML;

    }
    $('#itemBank')[0].innerHTML = newTable;
}

function rowClickedList(row){
    var jRow = $(row);

    var txtItemName = $('#name_input')[0];
    var txtPrice = $('#price_input')[0];
    var txtSalePrice = $('#sale_price_input')[0];

    var cells = jRow.find('td');
    txtItemName.value = cells[1].innerHTML;
    txtPrice.value =  cells[2].innerHTML;
    txtSalePrice.value = cells[3].innerHTML;
    $('#item_id_div')[0].innerHTML ='Item ID: ' +  cells[0].innerHTML;
    $('#selected_item_id').val(cells[0].innerHTML);
    $('#on_sale_input').attr("checked", cells[4].innerHTML === '✅');
    $('#gst_input').attr("checked", cells[5].innerHTML === '✅');
    $('#pst_input').attr("checked", cells[6].innerHTML === '✅');
    $('#hst_input').attr("checked", cells[7].innerHTML === '✅');
    $('#quantity_input')[0].value = cells[8].innerHTML;

    $('#update_msg')[0].innerHTML = '';
    $('#editItemListForm').show();
    $('#table-list').hide();
}

function rowClickedListList(cell){
    var jCell = $(cell);
    //var cells = jCell.siblings('td').find('.id');
    var cells = jCell.closest('tr').children('td.id');
    var listId = cells[0].innerHTML;
    window.location.href = "list.php?list_id=" + listId;
}

function cancelListClick(){
    $('#editItemListForm').hide();
    $('#table-list').show();
    $('#addItemForm').hide();
}

function cancelListListClick(){
    $('#addItemListForm').hide();
}

function removeClick(){
    $('#delete_input')[0].value = "yes";
    $('#submit-button')[0].click();
}

function addViewClick(){
    $('#editItemListForm').hide();
    $('#table-list').show();
    $('#addItemForm').show();
}

function addViewListClick(){
    var id = $('#listItemId')[0];
    id.value = -1;
    $('#editListBtn').hide();
    $('#addItemListForm').show();
}

function addItemClick(){
    $('#name_input')[0].value = "add";
    $('#submit-button')[0].click();
}

function editListListId(cell) {
    var jCell = $(cell);

    var list_name = $('#nameList_input')[0];
    var budget = $('#budget_input')[0];
    var id = $('#listItemId')[0];

    $('#editListBtn').show();

    var cells = jCell.siblings('td');
    id.value = cell.innerHTML;
    list_name.value =  cells[0].innerHTML;
    budget.value = cells[1].innerHTML;
    $('#item_id_div')[0].innerHTML ='Item ID: ' +  id.value;
    $('#addItemListForm').show();

}

function checkClicked(element){
    event.stopPropagation();
    var checkB = element.firstChild;
    var parent = element.parentElement;
    var id = parent.getElementsByClassName("id")[0].innerText;
    $('#id_input')[0].value = id;
    if(checkB.checked){
        $('#checking_input')[0].value = "checked";
    }
    else
    {
        $('#checking_input')[0].value = "unchecked";
    }
    $('#submit-button')[0].click();
}
function toggleCheckbox(element)
{
    if (element.checked == true)
    {
        var myId = element.id;
        $('#adding_input')[0].value = $('#adding_input')[0].value + " " + element.id;
    }
    else
    {
        var myId = element.id;
        var temp = $('#adding_input')[0].value;
        temp = temp.replace(myId +' ', '');
        $('#adding_input')[0].value = temp;
    }
}

function rowClicked(row){
    var jRow = $(row);

    var txtItemName = $('#name_input')[0];
    var txtPrice = $('#price_input')[0];
    var txtSalePrice = $('#sale_price_input')[0];

    var cells = jRow.find('td');
    txtItemName.value = cells[1].innerHTML;
    txtPrice.value =  cells[2].innerHTML;
    txtSalePrice.value = cells[3].innerHTML;
    $('#item_id_div')[0].innerHTML ='Item ID: ' +  cells[0].innerHTML;
    $('#selected_item_id').val(cells[0].innerHTML);
    $('#on_sale_input').attr("checked", cells[4].innerHTML === '✅');
    $('#gst_input').attr("checked", cells[5].innerHTML === '✅');
    $('#pst_input').attr("checked", cells[6].innerHTML === '✅');
    $('#hst_input').attr("checked", cells[7].innerHTML === '✅');

    $('#update_msg')[0].innerHTML = '';
    $('#itemBankList').hide();
    $('#editItemBankForm').show();
    $('#update_item').show();
    if (cells[8].innerHTML === 'yes')
        $('#DeleteItemBankItem').show();
    else
        $('#DeleteItemBankItem').hide();
    $('#add_item').hide();
}

function cancelClick(){
    $('#editItemBankForm').hide();
    $('#itemBankList').show();
}

function createItemClick(){
    $('#name_input')[0].value = '';
    $('#price_input')[0].value =  '';
    $('#sale_price_input')[0].value = '';
    $('#item_id_div')[0].innerHTML = '';
    $('#selected_item_id').val("-1");       //set to -1 to indicate a new item
    $('#on_sale_input').attr("checked", false);
    $('#gst_input').attr("checked", false);
    $('#pst_input').attr("checked", false);
    $('#hst_input').attr("checked", false);

    $('#update_msg')[0].innerHTML = '';
    $('#itemBankList').hide();
    $('#DeleteItemBankItem').hide();
    $('#editItemBankForm').show();
    $('#update_item').hide();
    $('#add_item').show();
}

function editItemsOfList()
{
    var id = $('#listItemId')[0];
    var address = "list.php?list_id=" + id.value;
    window.location.href = address;
}
