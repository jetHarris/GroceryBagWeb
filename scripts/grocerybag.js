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