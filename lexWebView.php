<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title></title>
	<meta name="author" content="">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="style.css" rel="stylesheet">
</head>

<body>

	<div class="form col2 container">
		<div>
			<label for="commandInput">
				<input id="commandInput" type="text" placeholder="Command"><br>
			</label>
			<label for="botNameInput">
				<input id="botNameInput" type="text" placeholder="BotName"><br>
			</label>
			<label for="arg1Input">
				<input id="arg1Input" type="text" placeholder="arg1 (optional)"><br>
			</label>
			<label for="arg2Input">
				<input id="arg2Input" type="text" placeholder="arg2 (optional)"><br>
			</label>
		</div>
	</div>
	<div class="col2 container">
		<p>Common Commands:</p>
		<button onclick="clearValues();setValue('commandInput','getBots');">getBots</button>
		<button onclick="clearValues();setValue('commandInput','getBot');
						setValue('botNameInput','TestCollectReviews');
						">getBot('TestCollectReviews')</button>
		<button onclick="clearValues();
						setValue('commandInput','putBot');
						setValue('botNameInput','NewBotName');
						setValue('arg1Input','en-US');
						setValue('arg2Input','[\'intentName\' => \'<string>\',\'intentVersion\' => \'<string>\',]');
						">putBot</button>
		<br>
		<button onclick="clearValues();setValue('commandInput','getIntents');">getIntents</button>
		<button onclick="clearValues();
						setValue('commandInput','getIntent');
						setValue('botNameInput','GetReview');
						">getIntent('GetReview')</button>
		<button onclick="clearValues();setValue('commandInput','getSlotTypes');">getSlotTypes</button>
		<button onclick="clearValues();
						setValue('commandInput','getSlotType');
						setValue('botNameInput','Product');
						">getSlotType('Product')</button>
		<br>
		<button onclick="clearValues();
						setValue('commandInput','getExport');
						setValue('botNameInput','TestCollectReviews');
						setValue('arg1Input','1');
						">getExport('TestCollectReviews')</button>
		<hr>
		<button onclick="clearValues();">Clear Values</button>
	</div>
	
	<button class="submit" onclick="submit();">Submit</button>

	API Reference:<a href="https://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.LexModelBuildingService.LexModelBuildingServiceClient.html">
		docs.aws.amazon.com/.../LexModelBuildingServiceClient.html
	</a>
	<div class="container">
		<p>Result</p>
		<span id="results-error"></span>
		<pre id="results"> </pre>
	</div>
	<script src="script.js"></script>
</body>
</html>