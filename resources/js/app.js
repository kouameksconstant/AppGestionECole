import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('createClassForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        fetch("{{ route('classes.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Ajoutez cette ligne pour vérifier la réponse
            if (data.success) {
                window.location.href = "{{ route('classes.index') }}"; 
            } else {
                alert('Erreur lors de la création de la classe : ' + data.message);
            }
        })
        .catch(error => console.error('Erreur:', error));
    });
});
