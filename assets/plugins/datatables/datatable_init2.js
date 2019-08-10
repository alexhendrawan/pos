jQuery.fn.dataTable.Api.register('sum()', function () {
    return this.flatten().reduce(function (a, b) {
        return (a * 1) + (b * 1); // cast values in-case they are strings
    });
});


var table = $('#tabel').DataTable({
    dom: 'lBfrtip',
    buttons: [
        'copy', 'excel', 'pdf'
    ],
    "search": {
        "smart": true
    },

});

var totalsum = table.column(6, {page: "all"}).data().sum();
val = totalsum;
var res = "Rp. " + number_format(val, 2, ",", ".");
$(".totalhutang").text(res);


$("#tabel").on('search.dt', function () {
    var totalsum = table.column(6, {"filter": "applied"}).data().sum();
    val = totalsum;
    var res = "Rp. " + number_format(val, 2, ",", ".");

    $(".totalhutang").text(res);
});


$("#tabel_filter").on("focusin", function () {
    $("tfoot").show();
})

$("#tabel_filter").on("focusout", function () {
    $("tfoot").hide();
})

// Find a <table> element with id="myTable":
var table = document.getElementById("tabel");

// Create an empty <tfoot> element and add it to the table:
var footer = table.createTFoot();
footer.style.display = "none";

$("thead > tr").clone().appendTo('tfoot');

// Setup - add a text input to each footer cell
$('#tabel tfoot tr th').each(function () {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Search" />');
});


// Apply the search
table.columns().every(function () {
    var that = this;

    $('input', this.footer()).on('keyup change', function () {
        if (that.search() !== this.value) {
            that
                .search(this.value)
                .draw();
        }
    });
});