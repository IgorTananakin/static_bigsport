<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

// Подключаем клиент Google таблиц
require_once __DIR__ . '/vendor/autoload.php';

// Наш ключ доступа к сервисному аккаунту
$googleAccountKeyFilePath = __DIR__ . '/service_key.json';
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath);

// Создаем новый клиент
$client = new Google_Client();
// Устанавливаем полномочия
$client->useApplicationDefaultCredentials();

// Добавляем область доступа к чтению, редактированию, созданию и удалению таблиц
$client->addScope(['https://www.googleapis.com/auth/drive', 'https://www.googleapis.com/auth/spreadsheets']);




$service = new Google_Service_Sheets($client);

// ID таблицы
$spreadsheetId = '1PoWWfXoP7kOA8DrGoN46-zoYC7Ny9twhjpFTFUQSFME';//1Uchevo9xfyq0-reRsiH9scTYU_7u8aUHmYA1TjyHPHo

$response = $service->spreadsheets->get($spreadsheetId);

// Идентификатор таблицы
//var_dump($response->spreadsheetId);

// URL страницы
//var_dump($response->spreadsheetUrl);

// Получение свойств таблицы
$spreadsheetProperties = $response->getProperties();

// Имя таблицы
//var_dump($spreadsheetProperties->title);

// Обход всех листов
foreach($response->getSheets() as $sheet) {

        // Получаем свойства листа
        $sheetProperties = $sheet->getProperties();
        // Идентификатор листа
        //var_dump($sheetProperties->index);
        // Имя листа
        //var_dump($sheetProperties->title);
}


// Объект - свойства таблицы
$SpreadsheetProperties = new Google_Service_Sheets_SpreadsheetProperties();
// Название таблицы
$SpreadsheetProperties->setTitle('NewSpreadsheet');
// Объект - таблица
$Spreadsheet = new Google_Service_Sheets_Spreadsheet();
$Spreadsheet->setProperties($SpreadsheetProperties);
// Делаем запрос
$response = $service->spreadsheets->create($Spreadsheet);

// Выводим идентификатор и url новой таблицы
//var_dump($response->spreadsheetId);
//var_dump($response->spreadsheetUrl);

// Объект - диск
$Drive = new Google_Service_Drive($client);
// Объект - разрешения диска
$DrivePermisson = new Google_Service_Drive_Permission();
// Тип разрешения
$DrivePermisson->setType('user');
// Указываем свою почту
$DrivePermisson->setEmailAddress('tananakinigor98@gmail.com');
// Права на редактирование
$DrivePermisson->setRole('writer');
// Выполняем запрос с нашим spreadsheetId, полученным в предыдущем примере 1Uchevo9xfyq0-reRsiH9scTYU_7u8aUHmYA1TjyHPHo
$response = $Drive->permissions->create('1PoWWfXoP7kOA8DrGoN46-zoYC7Ny9twhjpFTFUQSFME', $DrivePermisson);

$Drive = new Google_Service_Drive($client);
$DrivePermissions = $Drive->permissions->listPermissions($spreadsheetId);

foreach ($DrivePermissions as $key => $value) {
    $role = $value->role;
    
    //var_dump($role);
}

// Диапазон, в котором мы определяем заполненные данные. Например, если указать диапазон A1:A10
// и если ячейка A2 ячейка будет пустая, то новое значение запишется в строку, начиная с A2.
// Поэтому лучше перестраховаться и указать диапазон побольше:
$range = 'A1:Z';
// Данные для добавления
$values = [
  [
      "Сезон с лигой", "Хозяева", "Счёт хозяев", "Счёт гостей", "Гости", "Дата ",
      "Время "
],
];
// Объект - диапазон значений
$ValueRange = new Google_Service_Sheets_ValueRange();
// Устанавливаем наши данные
$ValueRange->setValues($values);
// Указываем в опциях обрабатывать пользовательские данные
$options = ['valueInputOption' => 'USER_ENTERED'];
// Добавляем наши значения в последнюю строку (где в диапазоне A1:Z все ячейки пустые) 1Uchevo9xfyq0-reRsiH9scTYU_7u8aUHmYA1TjyHPHo
$service->spreadsheets_values->append('1PoWWfXoP7kOA8DrGoN46-zoYC7Ny9twhjpFTFUQSFME', $range, $ValueRange, $options);




// // Экспорт в Excel
// // 25.03.2022
// $division = $_GET["division"];
// $date = $_GET["date"];
// $format = $_GET["format"];



echo "<br>";
// $jsondata2 = file_get_contents("https://scout.bigsports.ru/wp-json/scout_calendar/v1/league=17910,17911,17912,17913,17914,19276,19277,19278,19279/date=09.03.2022/status=4");
// //$jsondata2 = json_decode("https://scout.bigsports.ru/wp-json/scout_calendar/v1/league=17910,17911,17912,17913,17914,19276,19277,19278,19279/date=09.03.2022/status=4",true);
// $jsonDecoded = json_decode($jsondata2, true); // add true, will handle as associative array

$excelData = [];
if (is_array($result_sql)) {
    // $i = 1;
    //     foreach ($result_sql as $line ) {
    //         $i++;
    //         foreach ($line as $key => $value) {
                
    //             $sheet->setCellValue('A' . $i, $line["лига_с_дивизионом"]);
    //             $sheet->setCellValue('B' . $i, $line["хозяева"]);
    //             $sheet->setCellValue('C' . $i, $line["счёт_хозяев"]);
    //             $sheet->setCellValue('D' . $i, $line["счёт_гостей"]);
    //             $sheet->setCellValue('E' . $i, $line["гости"]);
    //             $sheet->setCellValue('F' . $i, $line["дата"]);
    //             $sheet->setCellValue('G' . $i, $line["время"]);
    //         }
    //     }
    foreach ($result_sql as $line) {

        //var_dump($line);
        foreach ($line as $key => $value) {

            $lineData = array($line["лига_с_дивизионом"], $line["хозяева"], $line["счёт_хозяев"], $line["счёт_гостей"],
							  $line["гости"], $line["дата"], $line["время"]
					    
            );
            
            
            $excelData = array_merge($excelData,$lineData);

            // Диапазон, в котором мы определяем заполненные данные. Например, если указать диапазон A1:A10
            // и если ячейка A2 ячейка будет пустая, то новое значение запишется в строку, начиная с A2.
            // Поэтому лучше перестраховаться и указать диапазон побольше:
            $range = 'A1:Z';
            // Данные для добавления
            $values = [
            [
                $line["лига_с_дивизионом"], $line["хозяева"], $line["счёт_хозяев"], $line["счёт_гостей"],
							  $line["гости"], $line["дата"], $line["время"] 
            ],
            ];
            // Объект - диапазон значений
            $ValueRange = new Google_Service_Sheets_ValueRange();
            // Устанавливаем наши данные
            $ValueRange->setValues($values);
            // Указываем в опциях обрабатывать пользовательские данные
            $options = ['valueInputOption' => 'USER_ENTERED'];
            // Добавляем наши значения в последнюю строку (где в диапазоне A1:Z все ячейки пустые)
            $service->spreadsheets_values->append('1PoWWfXoP7kOA8DrGoN46-zoYC7Ny9twhjpFTFUQSFME', $range, $ValueRange, $options);
        }

        


    }
}?>
<a href="https://docs.google.com/spreadsheets/d/1PoWWfXoP7kOA8DrGoN46-zoYC7Ny9twhjpFTFUQSFME/edit#gid=0">результат</a>


