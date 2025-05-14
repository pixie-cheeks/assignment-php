const fetchDataURL = `${BASE_URL}/server/fetch-database.php`;
const phpFetch = (fetchUrl, fetchBody) =>
  fetch(fetchUrl, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
    body: JSON.stringify(fetchBody),
  });

const sessionFetch = (actionName, inputObject) =>
  phpFetch(fetchDataURL, {
    action: actionName,
    inputObject,
  });

const fetchData = async (actionName, inputObject) => {
  try {
    const response = await phpFetch(fetchDataURL, {
      action: actionName,
      inputObject,
    });
    if (!response.ok) throw new Error(`Response Status: ${response.status}`);
    const data = await response.json();
    if (data.error) throw new Error(data.error.message);
    return data;
  } catch (error) {
    console.error(error);
    return false;
  }
};

export { fetchData, phpFetch, sessionFetch };
