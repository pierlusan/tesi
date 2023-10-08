const editGroupNameForm = document.getElementById('editGroupNameForm');
const editGroupDescForm = document.getElementById('editGroupDescForm');
const groupNameDisplay = document.getElementById('groupName');
const groupDescDisplay = document.getElementById('groupDesc');
const editButton = document.getElementById('editGroupButton');
const saveButton = document.getElementById('saveEdit');
const cancelEdit = document.getElementById('cancelEdit');


editButton.addEventListener('click', function () {
    groupNameDisplay.style.display = 'none';
    editGroupNameForm.style.display = 'block';
    groupDescDisplay.style.display = 'none'
    editGroupDescForm.style.display = 'block';
    editButton.style.display = 'none';
    saveButton.style.display = 'block';
    cancelEdit.style.display = 'block';
});

cancelEdit.addEventListener('click', function () {
    groupNameDisplay.style.display = 'block';
    editGroupNameForm.style.display = 'none';
    groupDescDisplay.style.display = 'block'
    editGroupDescForm.style.display = 'none';
    editButton.style.display = 'block';
    saveButton.style.display = 'none';
    cancelEdit.style.display = 'none';
});

saveButton.addEventListener('click', function () {
    const newGroupName = document.getElementById('newGroupName').value;
    const newGroupDesc = document.getElementById('newGroupDesc').value;
    const groupId = window.groupId;
    const groupDesc = window.groupDesc;
    const csrfToken = window.csrfToken;

    fetch(`/groups/${groupId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ name: newGroupName, description: newGroupDesc }),
    })
        .then((response) => response.json())
        .then((data) => {
            groupNameDisplay.textContent = newGroupName;
            groupDescDisplay.textContent = newGroupDesc;

            groupNameDisplay.style.display ='block';
            groupDescDisplay.style.display ='block';
            editGroupNameForm.style.display = 'none';
            editGroupDescForm.style.display = 'none';
            editButton.style.display = 'block';
            saveButton.style.display = 'none';
            cancelEdit.style.display = 'none';
        })
        .catch((error) => {
            console.error('Errore durante l\'aggiornamento del nome del gruppo:', error);
        });
});
