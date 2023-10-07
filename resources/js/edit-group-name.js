const editButton = document.getElementById('editGroupNameButton');
const saveButton = document.getElementById('saveGroupName');
const editGroupNameForm = document.getElementById('editGroupNameForm');
const groupNameDisplay = document.getElementById('group-name-display');
const cancelEdit = document.getElementById('cancelEdit');

editButton.addEventListener('click', function () {
    groupNameDisplay.style.display = 'none';
    editGroupNameForm.style.display = 'block';
    editButton.style.display = 'none';
    saveButton.style.display = 'block';
    cancelEdit.style.display = 'block';
});

cancelEdit.addEventListener('click', function () {
    groupNameDisplay.style.display = 'block';
    editGroupNameForm.style.display = 'none';
    editButton.style.display = 'block';
    saveButton.style.display = 'none';
    cancelEdit.style.display = 'none';
});

saveButton.addEventListener('click', function () {
    const newGroupName = document.getElementById('newGroupName').value;
    const groupId = window.groupId;

    fetch(`/groups/${groupId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ name: newGroupName }),
    })
        .then((response) => response.json())
        .then((data) => {
            groupNameDisplay.textContent = newGroupName;
            //groupNameDisplay.style.fontWeight = 'bold';
            //groupNameDisplay.style.color = '#000';

            editGroupNameForm.style.display = 'none';
            editButton.style.display = 'block';
            saveButton.style.display = 'none';
            groupNameDisplay.style.display ='block';
        })
        .catch((error) => {
            console.error('Errore durante l\'aggiornamento del nome del gruppo:', error);
        });
});
