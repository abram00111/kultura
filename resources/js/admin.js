require ("../plugins/bootstrap/js/bootstrap.bundle.min.js");
require ("../dist/js/adminlte.js");
require ("../plugins/chart.js/Chart.min.js");
require ("../dist/js/pages/dashboard3.js");
require ("./table.js");

//Показать выбранную картинку
function readURL(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#customFile").change(function() {
    readURL(this);
});
