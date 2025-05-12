import { fetchData, sessionFetch } from './utils/js-utils.js';

const afterDeleteListeners = [];

const editEmployee = async (empId) => {
  const response = await sessionFetch('setEditEmployeeId', { empId });

  const { error } = await response.json();
  if (error) {
    console.error('Error setting user ID');
  } else {
    globalThis.location.href = 'edit-employee';
  }
};
const deleteEmployee = async (empId) => {
  // eslint-disable-next-line no-alert
  const shouldDelete = globalThis.confirm('Are you sure?');
  if (!shouldDelete) return;
  await fetchData('deleteEmployee', { empId });
  afterDeleteListeners.forEach((listener) => listener());
};

const createEmployeeRow = (
  /* eslint-disable camelcase */
  { id: mainId, self_id, first_name, last_name, position_id, is_active },
  positions,
) => {
  const positionTitle = positions.find(({ id }) => id === position_id).title;
  const tr = document.createElement('tr');
  tr.innerHTML = `
  <td>${self_id}</td>
  <td>${first_name}</td>
  <td>${last_name}</td>
  <td>${positionTitle}</td>
  <td>${is_active ? 'Yes' : 'No'}</td>
  <td>
    <button class="js-edit-button btn btn-outline-dark">Edit</button>
    <button class="js-delete-button btn btn-danger">Delete</button>
  </td>
  `;
  /* eslint-enable camelcase */
  tr.className = 'align-baseline';
  tr.querySelector('.js-edit-button').addEventListener('click', () =>
    editEmployee(mainId),
  );
  tr.querySelector('.js-delete-button').addEventListener('click', () =>
    deleteEmployee(mainId),
  );

  return tr;
};

const render = async () => {
  const tBody = document.querySelector('.js-tbody');
  const [employeesData, positions] = await Promise.all([
    fetchData('getAllEmployees'),
    fetchData('getPositions'),
  ]);
  const tBodyFrag = document.createDocumentFragment();

  employeesData.forEach((employee) =>
    tBodyFrag.append(createEmployeeRow(employee, positions)),
  );

  tBody.innerHTML = '';
  tBody.append(tBodyFrag);
};

const addButton = document.querySelector('.js-add-button');

afterDeleteListeners.push(render);
await render();
addButton.addEventListener('click', () => {
  globalThis.location.href = 'add-employee';
});
