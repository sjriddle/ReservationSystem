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
  window.location = `http://uvu-reservation.test/reserve/edit/${id}`;
}
