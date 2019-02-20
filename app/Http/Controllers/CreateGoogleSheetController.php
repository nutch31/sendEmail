<?php

namespace App\Http\Controllers;
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;

use Illuminate\Http\Request;

class CreateGoogleSheetController extends Controller
{
    ////
    public function createGoogleSheet()
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.storage_path(env('MY_SECRET')));
        //putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/my_secret.json');
		/*  SEND TO GOOGLE SHEETS */
		 $client = new \Google_Client;
			try{
				$client->useApplicationDefaultCredentials();
			  $client->setApplicationName("Create-Google-Sheet");
				$client->setScopes(['https://www.googleapis.com/auth/drive','https://spreadsheets.google.com/feeds']);
			   if ($client->isAccessTokenExpired()) {
					$client->refreshTokenWithAssertion();
				}
				$accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
				ServiceRequestFactory::setInstance(
					new DefaultServiceRequest($accessToken)
				);
			   // Get our spreadsheet
				$spreadsheet = (new \Google\Spreadsheet\SpreadsheetService)
					->getSpreadsheetFeed()
					->getByTitle('TEST');

				//Add Worksheet Name, Number of rows, Number of columns
				$spreadsheet->addWorksheet('ZZZZ', 50, 20);

				// Get the first worksheet (tab)
				$worksheets = $spreadsheet->getWorksheetFeed()->getEntries();
				$newSheet = count($worksheets)-1;
				$worksheet = $worksheets[$newSheet];

				/*retreive
				$listFeed = $worksheet->getListFeed();
				foreach ($listFeed->getEntries() as $entry) {
					$values = $entry->getValues();
					print_r($values);
				}
				*/

				$cellFeed = $worksheet->getCellFeed();

				$cellFeed->editCell(1,1, "Row1Col1Header");
				$cellFeed->editCell(1,2, "Row1Col2Header");

				$batchRequest = new \Google\Spreadsheet\Batch\BatchRequest();
				$batchRequest->addEntry($cellFeed->createCell(2, 1, "111"));
				$batchRequest->addEntry($cellFeed->createCell(3, 1, "222"));
				$batchRequest->addEntry($cellFeed->createCell(4, 1, "333"));
				$batchRequest->addEntry($cellFeed->createCell(5, 1, "=SUM(A2:A4)"));

				$batchResponse = $cellFeed->insertBatch($batchRequest);

				/*
				$cellFeed = $worksheet->getCellFeed();

				$cellFeed->editCell(1,1, "Row1Col1Header");
				$cellFeed->editCell(1,2, "Row1Col2Header");
				$cellFeed->editCell(1,3, "Row1Col2Header");
				$cellFeed->editCell(1,4, "Row1Col2Header");
				$cellFeed->editCell(1,5, "Row1Col2Header");
				$cellFeed->editCell(1,6, "Row1Col2Header");

				$cellFeed->editCell(2,1, "XX");
				$cellFeed->editCell(2,2, "AA");
				$cellFeed->editCell(2,3, "CC");
				$cellFeed->editCell(2,4, "DD");
				$cellFeed->editCell(2,5, "eE");
				$cellFeed->editCell(2,6, "FF");

				$listFeed = $worksheet->getListFeed();
				*/

				//$listFeed->insert(["name" => "Someone", "age" => 25]);

			}catch(Exception $e){
			  echo $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile() . ' ' . $e->getCode;
			}

			/*  SEND TO GOOGLE SHEETS */
    }
}
