function calculatetotal(count) {
    $("#nilaifak").val(0);
    for (var i = 1; i <= $(".count").val(); i++) {

        var harga = $("#pp-get-" + i).val();
        var qty = $("#qty-get-" + i).val();
        var sebelum = $("#nilaifak").val();

        $("#nilaifak").val(parseInt(sebelum) + (parseInt(harga) * parseInt(qty)));
    }

}

$('.branch').select2({
    selectOnClose: true,
    minimumResultsForSearch: -1,
    placeholder: 'Pilih Cabang',
    ajax: {
        url: baseUrl + '/ajaxbranch',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.branchCode,
                        id: item.branchId

                    }

                })

            };
        },
        cache: true

    }

});

$('.salesemployee').select2({
    selectOnClose: true,
    placeholder: 'Pilih Pegawai',
    ajax: {
        url: baseUrl + '/ajaxuser/3',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.displayName,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.driveremployee').select2({
    selectOnClose: true,
    placeholder: 'Pilih Pegawai',
    ajax: {
        url: baseUrl + '/ajaxuser/4',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.displayName,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.kenekemployee').select2({
    selectOnClose: true,
    placeholder: 'Pilih Pegawai',
    ajax: {
        url: baseUrl + '/ajaxuser/5',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.displayName,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.userall').select2({
    selectOnClose: true,
    placeholder: 'Pilih Karyawan',
    ajax: {
        url: baseUrl + '/ajaxusersall',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.displayName,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});




$('.inventoris').select2({
    selectOnClose: true,
    placeholder: 'Pilih Inventaris',
    ajax: {
        url: baseUrl + '/ajaxinventoris',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.city').select2({
    selectOnClose: true,
    placeholder: 'Pilih Kota',
    ajax: {
        url: baseUrl + '/ajaxcity',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.type + " " + item.city_name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.satuan').select2({
    selectOnClose: true,
    placeholder: 'Pilih satuan',
    ajax: {
        url: baseUrl + '/ajaxsatuan',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.salesdp').select2({
    selectOnClose: true,
    minimumResultsForSearch: -1,
    placeholder: 'Pilih dp sales',
    ajax: {
        url: baseUrl + '/ajaxsalesdp',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.id + "--" + item.sales_dp_value,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.purchaseinv').select2({
    selectOnClose: true,
    placeholder: 'Pilih Purch. INV',
    ajax: {
        url: baseUrl + '/ajaxpurchinv',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {


                    return {
                        text: item.internal_invoice_no + " " + item.poheader.supplier_code.supplier_name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$(".purchaseinv").change(function () {

    $("#var1").val($(".purchaseinv :selected").text());
    var supplierid = 0;
    $.ajax({
        url: BASEURL_API + "/purchase_invoice_header/" + $(".purchaseinv").val(),
        method: "get",
        success: function (response) {
            $("#var100").val((response['data']['invoice_total']) - ((response['data']['paid_total'])));
            if ($("#var100").val() <= 0) {
                $("#var100").val(0);
            }
            supplierid = response['data']['poheader']['supplier_code']['id'];

            $('.debit').select2({
                selectOnClose: true,
                minimumResultsForSearch: -1,
                placeholder: 'Pilih Debit',
                ajax: {
                    url: baseUrl + '/ajaxdebit/supplier/' + supplierid,
                    dataType: 'json',
                    delay: 600,
                    processResults: function (data) {

                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.debit_memo_no + " Jumlah Debit: " + item.remain,
                                    id: item.id

                                }

                            })

                        };
                    },
                    cache: true

                }

            });
        }, error: function (xhr, statusCode, error) {

        }
    });






    $('.debit').select2({
        selectOnClose: true,
        minimumResultsForSearch: -1,
        placeholder: 'Pilih Debit',
        ajax: {
            url: baseUrl + '/ajaxdebit/supplier/' + supplierid,
            dataType: 'json',
            delay: 600,
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.debit_memo_no,
                            id: item.id

                        }

                    })

                };
            },
            cache: true

        }

    });



})



$('.warehouse').select2({
    selectOnClose: true,
    minimumResultsForSearch: -1,
    placeholder: 'Pilih Gudang',
    ajax: {
        url: baseUrl + '/ajaxwarehouse',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.warehouse_name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.customer').select2({
    selectOnClose: true,
    placeholder: 'Pilih Pembeli',
    ajax: {
        url: baseUrl + '/ajaxcustomer',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$(".customer").change(function(){
    $.ajax({
        url: BASEURL_API + "customer/" + $(".customer").val(),
        method: "get",
        success: function (response) {
            $("#alamatcust").text(response['data']['customer_address']);
            $("#phonecust").text(response['data']['customer_phone_no']);
            $("#salescust").text(response['data']['sales']['displayName']);
        },
        error: function (xhr, statusCode, error) {
        }
    });
})

var nilai = 0;
$('.podp').select2({
    selectOnClose: true,

    placeholder: 'Pilih PO DP',
    ajax: {
        url: baseUrl + '/ajaxpodp',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {
                    nilai = item.po_dp_value;

                    return {
                        text: item.po_dp_no + "--" + item.po_dp_value,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});





$('.bankcash').select2({
    selectOnClose: true,
    minimumResultsForSearch: -1,
    placeholder: 'Pilih Bank',
    ajax: {
        url: baseUrl + '/ajaxbank',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.account_name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.debit').select2({
    selectOnClose: true,
    minimumResultsForSearch: -1,
    placeholder: 'Pilih Debit',
    ajax: {
        url: baseUrl + '/ajaxdebit',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.debit_memo_no,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.credit').select2({
    selectOnClose: true,
    minimumResultsForSearch: -1,
    placeholder: 'Pilih Credit',
    ajax: {
        url: baseUrl + '/ajaxcredit',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.credit_memo_no,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.supplier').select2({
    selectOnClose: true,

    placeholder: 'Pilih supplier',
    ajax: {
        url: baseUrl + '/ajaxsupplier',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.supplier_name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$(".salesbycust").hover(function(){
    var id = $(".customer").val();

    $('.salesbycust').select2({
        selectOnClose: true,

        placeholder: 'Pilih Penjualan',
        ajax: {
            url: baseUrl + '/ajaxsalescustomer/'+id,
            dataType: 'json',
            delay: 600,
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.intnomorsales,
                            id: item.id

                        }

                    })

                };
            },
            cache: true

        }

    });
    
})
$(".customer").change(function(){
    var id = $(".customer").val();
    $('.itembycust').select2({
        selectOnClose: true,

        placeholder: 'Pilih Barang',
        ajax: {
            url: baseUrl + '/ajaxitembycustomer/'+id,
            dataType: 'json',
            delay: 300,
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.item_stock_id.item.item_id.item_name,
                            id: item.item_stock_id.id

                        }

                    })

                };
            },
            cache: true

        }

    });
    $('.salesbycust').select2({
        selectOnClose: true,

        placeholder: 'Pilih Penjualan',
        ajax: {
            url: baseUrl + '/ajaxsalescustomer/'+id,
            dataType: 'json',
            delay: 600,
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.intnomorsales,
                            id: item.id

                        }

                    })

                };
            },
            cache: true

        }

    });
    
})

$(".invbysupplier").hover(function(){
    var id = $(".supplier").val();
    
    $('.invbysupplier').select2({
        selectOnClose: true,

        placeholder: 'Pilih Invoice',
        ajax: {
            url: baseUrl + '/ajaxinvsupplier/'+id,
            dataType: 'json',
            delay: 600,
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.internal_invoice_no,
                            id: item.id

                        }

                    })

                };
            },
            cache: true

        }

    });

})


$(".invenbysupplier").hover(function(){
    $(".warehousebyitem").val(null).trigger('change');

    var id = $(".supplier").val();
    $('.invenbysupplier').select2({
        selectOnClose: true,

        placeholder: 'Pilih Barang',
        ajax: {
            url: baseUrl + '/ajaxitembysupplier/'+id,
            dataType: 'json',
            delay: 600,
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.item_id.item_name,
                            id: item.id

                        }

                    })

                };
            },
            cache: true

        }

    });



    $('.warehousebyitem').select2({
        selectOnClose: true,
        minimumResultsForSearch: -1,
        placeholder: 'Pilih Gudang',
        ajax: {
            url: baseUrl + '/ajaxwarehouseitem/'+ id,
            dataType: 'json',
            delay: 600,
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.warehouse_name,
                            id: item.id

                        }

                    })

                };
            },
            cache: true

        }

    });
})

$(".supplier").on('load change',function(){
    $(".invenbysupplier").val(null).trigger('change');
    
    var id = $(".supplier").val();
    $(".warehousebyitem").val(null).trigger('change');
    $('.invenbysupplier').select2({
        selectOnClose: true,

        placeholder: 'Pilih Barang',
        ajax: {
            url: baseUrl + '/ajaxitembysupplier/'+id,
            dataType: 'json',
            delay: 600,
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.item_id.item_name,
                            id: item.id

                        }

                    })

                };
            },
            cache: true

        }

    });
    $('.invbysupplier').select2({
        selectOnClose: true,

        placeholder: 'Pilih Invoice',
        ajax: {
            url: baseUrl + '/ajaxinvsupplier/'+id,
            dataType: 'json',
            delay: 600,
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.internal_invoice_no,
                            id: item.id

                        }

                    })

                };
            },
            cache: true

        }

    });
    $.ajax({
        url: BASEURL_API + "/supplier/"+ id,
        method: "get",
        success: function (response) {
            $("#alamatsupplier").text()
            $("#teleponsupplier").text()

            $("#alamatsupplier").text(response.data.supplier_address);
            $("#teleponsupplier").text(response.data.phone_num);
        },
        error: function (xhr, statusCode, error) {
        }
    });
})

$(".invenbysupplier").change(function(){
  $.ajax({
    url: BASEURL_API + "/item_stock/itemidwarehouse/"+$(".invenbysupplier").val(),
    method: "get",
    success: function (response) {
        $("#var5").val(response.data.purchase_price);
    },
    error: function (xhr, statusCode, error) {
    }
});
});

$(".invenbysupplier").change(function(){
    var id = $(".invenbysupplier").val();
    $(".warehousebyitem").val(null).trigger('change');





    $('.warehousebyitem').select2({
        selectOnClose: true,
        minimumResultsForSearch: -1,
        placeholder: 'Pilih Gudang',
        ajax: {
            url: baseUrl + '/ajaxwarehouseitem/'+ id,
            dataType: 'json',
            delay: 600,
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.warehouse_name,
                            id: item.id

                        }

                    })

                };
            },
            cache: true

        }

    });

});

$('.poheader').select2({
    selectOnClose: true,
    placeholder: 'Pilih PO',
    ajax: {
        url: baseUrl + '/ajaxpoheader',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.po_no + " " + item.supplier_code.supplier_name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.poheaderstatus').select2({
    selectOnClose: true,
    placeholder: 'Pilih PO',
    ajax: {
        url: baseUrl + '/ajaxpoheaderbystatus/C',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.po_no,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.poheaders').select2({
    selectOnClose: true,
    minimumResultsForSearch: -1,
    placeholder: 'Pilih PO',
    ajax: {
        url: baseUrl + '/ajaxpoheader',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.po_no + " " + item.supplier_code.supplier_name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.poheaders').change(function () {
    var id = $(".poheaders").val();
    $('.polines').select2({
        selectOnClose: true,

        placeholder: 'Pilih Barang PO',
        ajax: {
            url: baseUrl + '/ajaxpoline/' + id,
            dataType: 'json',
            delay: 600,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.item_id.item_id.item_name,
                            id: item.item_id.id
                        }
                    })
                };
            },
            cache: true
        }

    });
});

$('.polines').change(function () {
    var id = $(".polines").val();
    $.ajax({
        url: baseUrl + "/ajaxpoline/detail/" + id,
        method: "get",
        success: function (response) {
            if (response.qty_get == 0) {
                $("#var4").attr({
                    "max": response["qty_buy"],        // substitute your own
                    "min": 0          // values (or variables) here
                });
            } else {
                $("#var4").attr({
                    "max": response["qty_get"],        // substitute your own
                    "min": 0          // values (or variables) here
                });
            }
        },
        error: function (xhr, statusCode, error) {
        }
    });
});


$('.item').select2({
    selectOnClose: true,

    placeholder: 'Pilih Item',
    ajax: {
        url: baseUrl + '/ajaxitemcode',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.item_name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.brand').select2({
    selectOnClose: true,
    placeholder: 'Pilih Merk',
    ajax: {
        url: baseUrl + '/ajaxmerk',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.color').select2({
    selectOnClose: true,

    placeholder: 'Pilih Kategori',
    ajax: {
        url: baseUrl + '/ajaxcolor',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.katpeng').select2({
    selectOnClose: true,
    placeholder: 'Pilih Kategori Pengeluaran',
    ajax: {
        url: baseUrl + '/ajaxkatpeng',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$('.katpengadmin').select2({
    selectOnClose: true,
    placeholder: 'Pilih Kategori Pengeluaran',
    ajax: {
        url: baseUrl + '/ajaxkatpeng',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {
                   if(item.name != "Gaji" && item.name != "Komisi" && item.name != "Thr"){
                    return {
                        text: item.name,
                        id: item.id

                    }
                }
            })

            };
        },
        cache: true

    }

});


$('.stock').select2({
    selectOnClose: true,
    placeholder: 'Pilih stok',
    ajax: {
        url: baseUrl + '/ajaxitemstock',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.item.item_id.item_name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$(".stock").change(function () {

    $.ajax({
        url: baseUrl + "/ajaxitemstock/" + $(".stock").val(),
        method: "get",
        success: function (response) {
            $("#var10").val(response["sell_price"]);
            $("#var18").val(response['satuan_id']["name"]);
            $("#var20").val(response["purchase_price"]);
            $("#sell_price").val(response["sell_price"]);
            $("#buyprice").val(response["purchase_price"]);
            var newOption = new Option(response['satuan_id']["name"], response['satuan_id']["id"], true, true);
            $('.satuan').append(newOption).trigger('change');
            if(response["qty"] <= 0){
               // $("#var5").attr({
               //     "max" : 0,        
               //     "min" : 0           
               // });
                swal("Jumlah Stock 0. Harap melakukan pembelian terlebih dahulu");
               // $("#var3").val(null).trigger('change');
               // $("#var5").val(null);
               // $("#var10").val(null);
               // $("#var11").val(null);
               // $("#var20").val(null);
            }else{
              //  $("#var5").attr({
              //      "max" : response["qty"],        
              //      "min" : 1           
              //  });
            }
        },
        error: function (xhr, statusCode, error) {
        }
    });

})

$('.inven').select2({
    selectOnClose: true,

    placeholder: 'Pilih stok',
    ajax: {
        url: baseUrl + '/ajaxinven',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.item_id.item_name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$(".inven").change(function () {
    $.ajax({
        url: BASEURL_API + "item_stock/itemidwarehouse/" + $(".inven").val(),
        method: "get",
        success: function (response) {
            var newOption = new Option(response['data']['satuan_id']["name"], response['data']['satuan_id']["id"], true, true);
            $('.satuan').append(newOption).trigger('change');
        },
        error: function (xhr, statusCode, error) {
        }
    });
});

$('.role').select2({
    selectOnClose: true,

    placeholder: 'Pilih role',
    ajax: {
        url: baseUrl + '/ajaxrole',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

var grandsales = 0;
$('.salesC').select2({
    selectOnClose: true,

    placeholder: 'Pilih Sales',
    ajax: {
        url: baseUrl + '/ajaxitemsalesbystatusC',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.intnomorsales + " " + item.customer_id.name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});


$('.sales').select2({
    selectOnClose: true,

    placeholder: 'Pilih Sales',
    ajax: {
        url: baseUrl + '/ajaxitemsales',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {

            return {
                results: $.map(data, function (item) {

                    return {
                        text: item.intnomorsales + " " + item.customer_id.name,
                        id: item.id

                    }

                })

            };
        },
        cache: true

    }

});

$(".sales").change(function () {
    $("#var1").val($(".sales").text());
    $.ajax({
        url: baseUrl + "/ajaxitemsalesheader/" + $(".sales").val(),
        method: "get",
        success: function (response) {
            $("#pembayaran").val(response["payment_remain"]);
            grandsales = response["payment_remain"];


            $('.credit').select2({
                selectOnClose: true,
                minimumResultsForSearch: -1,
                placeholder: 'Pilih Credit',
                ajax: {
                    url: baseUrl + '/ajaxcredit/customer/' + response["customer_id"]["id"],
                    dataType: 'json',
                    delay: 600,
                    processResults: function (data) {

                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.credit_memo_no + " Jumlah Credit: " + item.remain,
                                    id: item.id

                                }

                            })

                        };
                    },
                    cache: true

                }

            });
        },
        error: function (xhr, statusCode, error) {
        }
    });

    var id = $(".sales").val();
    $('.salesline').select2({
        selectOnClose: true,

        placeholder: 'Pilih Barang Sales',
        ajax: {
            url: baseUrl + '/ajaxitemsales/' + id,
            dataType: 'json',
            delay: 600,
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.item_stock_id.item.item_id.item_name,
                            id: item.item_stock_id.id

                        }

                    })

                };
            },
            cache: true

        }

    });
});


$(".salesC").change(function () {
    $("#var1").val($(".salesC").text());
    $.ajax({
        url: baseUrl + "/ajaxitemsalesheader/" + $(".salesC").val(),
        method: "get",
        success: function (response) {
            $("#pembayaran").val(response["payment_remain"]);
            grandsales = response["payment_remain"];


            $('.credit').select2({
                selectOnClose: true,
                minimumResultsForSearch: -1,
                placeholder: 'Pilih Credit',
                ajax: {
                    url: baseUrl + '/ajaxcredit/customer/' + response["customer_id"]["id"],
                    dataType: 'json',
                    delay: 600,
                    processResults: function (data) {

                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.credit_memo_no + " Jumlah Credit: " + item.remain,
                                    id: item.id

                                }

                            })

                        };
                    },
                    cache: true

                }

            });
        },
        error: function (xhr, statusCode, error) {
        }
    });

    var id = $(".salesC").val();
    $('.salesline').select2({
        selectOnClose: true,

        placeholder: 'Pilih Barang Sales',
        ajax: {
            url: baseUrl + '/ajaxitemsales/' + id,
            dataType: 'json',
            delay: 600,
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.item_stock_id.item.item_id.item_name,
                            id: item.item_stock_id.id

                        }

                    })

                };
            },
            cache: true

        }

    });
});


$("#diskonsales").change(function () {
    $("#pembayaran").val(grandsales);
    console.log(grandsales + " grandsales");
    console.log($("#pembayaran").val() + " val pembayaran");
    var awaltotsales = $("#pembayaran").val();
    console.log(awaltotsales + " val awaltotsales");
    console.log($("#diskonsales").val() + " val diskon");

    var akhirsales = awaltotsales - (awaltotsales * ($("#diskonsales").val() / 100));
    $("#diskonsalesr").val(awaltotsales * ($("#diskonsales").val() / 100));
    console.log(akhirsales + " val akhir");

    $("#pembayaran").val(akhirsales);

})


$("#var10").change(function () {

    var price1 = parseInt($("#var10").val());
    var price2 = parseInt($("#var20").val());
    if (price1 == 0) {
        swal('Barang akan dijadikan bonus');
    }
    else if (price1 < price2) {
        swal('Harga jual terlalu murah!');
        $(".dis").attr("disabled", true);
    } else {
        $(".dis").attr("disabled", false);

    };

})


