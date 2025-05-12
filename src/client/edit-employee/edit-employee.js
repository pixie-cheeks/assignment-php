/* eslint-disable camelcase */
import { fetchData } from '../../utils/js-utils.js';

const {
  id,
  self_id,
  first_name,
  middle_name,
  last_name,
  joining_date,
  position_id,
  current_address,
  is_active,
} = await fetchData('getEditingEmployee');
const allSelfIds = await fetchData('getAllSelfIds');
const cancelButton = document.querySelector('.js-cancel-button');
const form = document.querySelector('.js-form');
const dialog = document.querySelector('.js-dialog');
const dialogText = dialog.querySelector('p');
const dialogBtn = dialog.querySelector('button');

document.querySelector('#emp-id').value = self_id;
document.querySelector('#first-name').value = first_name;
document.querySelector('#middle-name').value = middle_name;
document.querySelector('#last-name').value = last_name;
document.querySelector('#joining-date').value = joining_date;
document.querySelector('#position-id').value = position_id;
document.querySelector('#address').value = current_address;
document.querySelector('#is-active').checked = is_active;

cancelButton.addEventListener('click', () => {
  globalThis.location.href = '/client';
});

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
  const dataToBeSent = {
    mainId: Number(id),
    empData: {
      self_id: Number(formData.get('emp-id')),
      first_name: formData.get('first-name'),
      middle_name: formData.get('middle-name'),
      last_name: formData.get('last-name'),
      joining_date: formData.get('joining-date'),
      position_id: Number(formData.get('position-id')),
      current_address: formData.get('address'),
      is_active: Boolean(formData.get('is-active')),
    },
  };

  if (allSelfIds.includes(dataToBeSent.empData.self_id)) {
    showDialog('The submitted Emp ID is a duplicate');
    return;
  }
  const isSubmitted = await fetchData('editEmployee', dataToBeSent);

  if (isSubmitted) globalThis.location.href = '/client';
});
