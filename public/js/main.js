const reservations = document.getElementById('reservations');
const items = document.getElementById('items');

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

if (items) {
  items.addEventListener('click', (e) => {
    if (e.target.className === 'btn btn-success change-status') {
      const id = e.target.getAttribute('item-id');
      fetch(`status/update/${id}`, {
        method: 'POST'
      }).then(res => window.location.reload())
    } else if (e.target.className === 'btn btn-danger change-status') {
      const id = e.target.getAttribute('item-id');
      fetch(`status/update/${id}`, {
        method: 'POST'
      }).then(res => window.location.reload())
    }
  });
}

function findId() {
  var id = document.getElementById('find_id').value;
  fetch(`/reserve/edit/${id}`, {
    method: 'GET'
  }).then(res => window.location = `/reserve/edit/${id}`);
}

