var tabla;

//funcion que se ejecuta al inicio
function init() {
  listar();
  //cargamos los items al select cliente
  $.post("Controllers/Product.php?op=selectArticulo", function (r) {
    $("#idarticulo").html(r);
    //$("#idarticulo").selectpicker("refresh");
  });
}
function listar() {
  var idarticulo = $("#idarticulo").val();

  $.post(
    "Controllers/Consult.php?op=kardex",
    { idarticulo: idarticulo },
    function (data, status) {
      console.log(data);
      $("#tbl").html(data);
    }
  );
}

init();
