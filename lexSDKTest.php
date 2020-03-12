<?php
require 'vendor/autoload.php';

//use Aws\S3\S3Client;
use Aws\Exception\AwsException;

use Aws\AwsClient;
use Aws\LexModelBuildingService;
use Aws\LexModelBuildingService\LexModelBuildingServiceClient;
// use Aws\LexRuntimeService;

echo "Start\n";
try {
	// The same options that can be provided to a specific client constructor can also be supplied to the Aws\Sdk class.
	// Use the us-west-2 region and latest version of each client.
	$sharedConfig = [
	'profile' => 'default',
	'region' => 'us-east-1',
	'version' => 'latest'
];

	// Create an SDK class used to share configuration across clients.
	$sdk = new Aws\Sdk($sharedConfig);

	// Create an Amazon S3 client using the shared configuration data.
	$client = $sdk->createlexmodelbuildingservice();
	//$client = $sdk->createlexruntimeservice();
	//$client = $sdk->create__();

	if (isset($_GET['runFunction'])) {
		$runFunction = $_GET['runFunction'];
		echo "----- Run function $runFunction -----\n";
		echo "----- (";
		if(isset($_GET['botName'])){echo $_GET['botName'];}
		else{echo "[botName Undefined]";}
		echo ", ";
		if(isset($_GET['arg1'])){echo $_GET['arg1'];}
		else{echo "[arg1 Undefined]";}
		echo ", ";
		if(isset($_GET['arg2'])){echo $_GET['arg2'];}
		else{echo "[arg2 Undefined]";}
		echo ") -----\n";

		//call_user_func($runFunction);
		switch ($runFunction) {
		case "getBots":
			$result = $client->getBots([
				'maxResults' => 15,
			]);
			$counter = 0;
			foreach ($result[bots] as $botItem) {
				$counter++;
				echo $counter . ") " . $botItem[name] . " | " . $botItem[status] . "\n";
			}
			echo "\n----- ----- ----- ----- ----- ----- -----\n";
			print_r($result);
			break;
		case "getBot":
			if (isset($_GET['botName'])) {
				if (isset($_GET['arg1'])) {//arg1 used as version
					$version = $_GET['arg1'];
				}else{
					$version = '$LATEST';
				}
				$result = $client->getBot([
					'name' => $_GET['botName'], // REQUIRED
					'versionOrAlias' => $version, // REQUIRED
				]);
				echo "\nBot Name: " . $result[name] . "\n";
				echo "\nIntents:\n";
				$counter = 0;
				foreach ($result[intents] as $intentItem) {
					$counter++;
					echo $counter . ") " . $intentItem[intentName] . " - v" . $intentItem[intentVersion] . "\n";
				}
				echo "\nClarification Prompts:\n";
				echo " MaxAttempts:" . $result[clarificationPrompt][maxAttempts] . "\n";
				$counter = 0;
				foreach ($result[clarificationPrompt][messages] as $clarifItem) {
					$counter++;
					echo $counter . ") " . $clarifItem[contentType] . " | " . $clarifItem[content] . "\n";
				}
				echo "\nAbort Statements:\n";
				$counter = 0;
				foreach ($result[abortStatement][messages] as $abortItem) {
					$counter++;
					echo $counter . ") " . $abortItem[contentType] . " | " . $abortItem[content] . "\n";
				}
				echo "\n----- ----- ----- ----- ----- ----- -----\n";
				print_r($result);
			} else {
				echo "GET argument botName required";
			}
			break;
		case "putBot":
			//Creates a new lex bot
			$result = $client->putBot([
				'name' => $_GET['botName'], // REQUIRED
				'childDirected' => false, // REQUIRED
				'locale' => $_GET['arg1'], // REQUIRED
				// 'intents' => $_GET['arg2'], // REQUIRED
			]);
			echo "\n----- ----- ----- ----- ----- ----- -----\n";
			print_r($result);
			break;
		case "Other":
			$result = $client->getUtterancesView([
				'botName' => '<string>', // REQUIRED
				'statusType' => 'Detected|Missed', // REQUIRED
			]);
			print_r($result);
			break;
		case "getIntents":
			$result = $client->getIntents([
				'maxResults' => 15,
			]);
			print_r($result);
			break;
		case "getIntent":
			$result = $client->getIntent([
				'name' => $_GET['botName'], // REQUIRED
				'version' => '$LATEST', // REQUIRED
			]);
			print_r($result);
			break;
		case "getSlotTypes":
			$result = $client->getSlotTypes([
				'maxResults' => 15,
			]);
			print_r($result);
			break;
		case "getSlotType":
			$result = $client->getSlotType([
				'name' =>  $_GET['botName'], // REQUIRED
				'version' => '$LATEST', // REQUIRED
			]);
			print_r($result);
			break;
		case "getExport":
			$result = $client->getExport([
				'exportType' => 'LEX', // REQUIRED
				'name' => $_GET['botName'], // REQUIRED
				'resourceType' => 'BOT', // REQUIRED
				'version' => $_GET['arg1'], // REQUIRED
			]);
			print_r($result);
			break;
		default:
			echo "Default Case - " . $runFunction . "\n";
			// $result = $client->call_user_func($runFunction, [
			//	 'maxResults' => 15,
			// ]);
			print_r($result);
			break;

	}
	}


	if (false) {
		echo "----- getbot -----\n";

		$result = $client->getBot([
	'name' => 'TestCollectReviews', // REQUIRED
	'versionOrAlias' => '$LATEST', // REQUIRED
]);

		print_r($result);
		echo "-----\n";
		echo $result['Body'];
		echo "\n-----Done getbot -----\n";

		function writeMsg($msg)
		{
			echo "Message: " . $msg . "\n";
		}


		echo "----- createBotVersion -----\n";
		writeMsg("Hello World!");

		$result = $client->createBotVersion([
		'name' => 'TestCreateBot', // REQUIRED
	]);
		// $promise = $client->createBotVersionAsync([/* ... */]);

		echo $result['Body'];
	}
} catch (Exception $e) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
echo "end\n";
