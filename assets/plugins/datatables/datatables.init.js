var tables = document.getElementById("tabel");

var footers = tables.createTFoot();
footers.classList.add("searchcolumn");
footers.style.display = "none";

$("thead > tr").clone().appendTo('tfoot');
$("tfoot > th").removeClass("col-head");

var table = $('#tabel').DataTable({
    dom: 'lBfrtip',
    buttons: [
    'copy', 'excel', 'pdf'
    ],
    search: {
        "smart": true
    },

});


$("#tabel_filter").on("click", function () {
    $(".searchcolumn").toggle();
})


$('.searchcolumn th').each(function () {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Search" />');
});

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


jQuery.fn.dataTable.Api.register('sum()', function () {
    return this.flatten().reduce(function (a, b) {
        return (a * 1) + (b * 1); // cast values in-case they are strings
    });
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
