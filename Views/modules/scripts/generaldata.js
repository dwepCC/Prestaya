function init() {
  mostrar_datosgenerales();
}

function mostrar_datosgenerales() {
  // var id_negocio = 1;
  $.post("Controllers/Company.php?op=mostrar_datos", function (data, status) {
    data = JSON.parse(data);

    $("#tipo_impuesto").html(data.nombre_impuesto);

    $("#smoneda_most_total").html(data.simbolo + " ");
    $("#smoneda_total").html(data.simbolo + " ");
    $("#smoneda_most_imp").html(data.simbolo + " ");
    //$("#valor_impuesto").html(data.nombre_impuesto + " " + data.monto_impuesto + "%");
  });
}
init();
