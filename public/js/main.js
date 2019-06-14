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

function findId() {
  var id = document.getElementById('find_id').value;
  fetch(`/reserve/edit/${id}`, {
    method: 'GET'
  }).then(res => window.location = `/reserve/edit/${id}`);
}

function autofillFormDate() {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

  today = mm + '/' + dd + '/' + yyyy;
  document.getElementById('form_res_date').value = today;
  console.log(today)
}
