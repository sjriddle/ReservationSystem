const reservations = document.getElementById('reservations');

if (reservations) {
  reservations.addEventListener('click', (e) => {
    if (e.target.className === 'btn btn-danger delete-reservation') {
      if (confirm('Are you sure?')) {
        const id = e.target.getAttribute('data-id');
        fetch(`/reserve/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.reload());
      }
    }
  });
}

var today = new Date();
var cur_time = today.getHours() + ':' + today.getMinutes();
console.log(document.getElementById('form_res_time').value);
console.log(cur_time);
if (document.getElementById('form_res_time').value < cur_time) {
  console.log('test')
}

function findId() {
  var id = document.getElementById('find_id').value;
  fetch(`/reserve/edit/${id}`, {
    method: 'GET'
  }).then(res => window.location = `/reserve/edit/${id}`);
}

$('#form_res_time').datetimepicker({
  format : 'DD/MM/YYYY hh:mm A'
});

document.getElementById('form_res_date').value = Date();

(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();