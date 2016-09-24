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
}

function cancelClick(){
    $('#editItemBankForm').hide();
    $('#itemBankList').show();
}