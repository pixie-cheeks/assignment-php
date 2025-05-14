import { fetchData } from '../utils/js-utils.js';

const cancelButton = document.querySelector('.js-cancel-button');
const form = document.querySelector('.js-form');
const empIdField = document.querySelector('.js-emp-id');
const allSelfIds = await fetchData('getAllSelfIds');
const dialog = document.querySelector('.js-dialog');
const dialogText = dialog.querySelector('p');
const dialogBtn = dialog.querySelector('button');

cancelButton.addEventListener('click', () => {
  globalThis.location.href = BASE_URL;
});

let suggestedID = 1;
allSelfIds
  .sort((a, b) => a - b)
  .some((id) => {
    if (id === suggestedID) {
      suggestedID++;
      return false;
    }
    return true;
  });

empIdField.value = suggestedID;

dialogBtn.addEventListener('click', () => {
  dialog.close();
});

const showDialog = (message) => {
  dialogText.textContent = message;
  dialog.showModal();
};

form.addEventListener('submit', async (event) => {
  event.preventDefault();
  const formData = new FormData(form);
  const empData = {
    self_id: Number(formData.get('emp-id')),
    first_name: formData.get('first-name'),
    middle_name: formData.get('middle-name'),
    last_name: formData.get('last-name'),
    joining_date: formData.get('joining-date'),
    position_id: Number(formData.get('position-id')),
    current_address: formData.get('address'),
    is_active: Boolean(formData.get('is-active')),
  };

  if (allSelfIds.includes(empData.self_id)) {
    showDialog('The submitted Emp ID is a duplicate');
    return;
  }

  const isSubmitted = await fetchData('createEmployee', empData);

  if (isSubmitted) globalThis.location.href = BASE_URL;
});
