<?php
require_once __DIR__ . '/database-manager.php';
require_once __DIR__ . '/../utils/respond.php';
$input = (array) json_decode(file_get_contents('php://input'));

if (empty($input)) {
    respondError('No input given');
}

$database = new Database();

function getInputObj(): array
{
    global $input;
    $inputObj = (array) $input['inputObject'];
    return $inputObj;
}

function getValidInput(array $array): array
{
    $typedArr = [
        'self_id' => (int) $array['self_id'],
        'first_name' => (string) $array['first_name'],
        'middle_name' => (string) $array['middle_name'],
        'last_name' => (string) $array['last_name'],
        'current_address' => (string) $array['current_address'],
        'position_id' => (int) $array['position_id'],
        'joining_date' => (string) $array['joining_date'],
        'is_active' => $array['is_active'] ? 1 : 0,

    ];

    if ($typedArr['joining_date'] === '') {
        unset($typedArr['joining_date']);
    }
    return $typedArr;
}

function getAllEmployees(): void
{
    global $database;
    respond($database->getAllEmployees());
}

function getPositions(): void
{
    global $database;
    respond($database->getPositions());
}

function createEmployee(): void
{
    global $input, $database;
    $castInput = (array) $input['inputObject'];
    /** @psalm-suppress MixedArgumentTypeCoercion */
    $result = $database->createEmployee(getValidInput($castInput));
    respond($result);
}

function getEditingEmployee(int $empId): array | false
{
    global $database;

    return $database->getEmployee($empId);
}

function editEmployee(): bool
{
    global $database;

    $empData = (array) getInputObj()['empData'];
    $validEmpData = getValidInput($empData);

    /** @psalm-suppress MixedArgumentTypeCoercion */
    return $database->updateEmployee((int) getInputObj()['mainId'], $validEmpData);
}

switch ($input['action']) {
    case 'getAllEmployees':
        getAllEmployees();
        break;
    case 'getPositions':
        getPositions();
        break;
    case 'createEmployee':
        createEmployee();
        break;
    case 'setEditEmployeeId':
        session_start();
        if (isset(getInputObj()['empId'])) {
            $_SESSION['empId'] = (int) getInputObj()['empId'];
            respond(['message' => 'The ID has been stored.']);
        } else {
            respondError('empId was unset');
        }
        break;
    case 'getEditingEmployee':
        session_start();
        $employee = getEditingEmployee((int) $_SESSION['empId']);

        if (boolval($employee)) {
            respond($employee);
        } else {
            respondError('Unable to find the employee');
        }
        break;
    case 'editEmployee':
        if (editEmployee()) {
            respond(['message' => 'Edited successfully']);
        } else {
            respondError("Couldn't edit employee");
        }
        break;
    case 'deleteEmployee':
        session_start();

        if (! isset(getInputObj()['empId'])) {
            respondError('empId is unset');
            die();
        }

        $empId = (int) getInputObj()['empId'];
        if ($database->deleteEmployee($empId)) {
            respond(['message' => 'Deleted Successfully']);
        } else {
            respondError("Couldn't delete employee");
        }
        break;
    case 'getAllSelfIds':
        respond($database->getAllSelfIds());
        break;
    default:
        respondError('Invalid action');
}