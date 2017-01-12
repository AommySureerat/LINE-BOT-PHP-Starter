<?php
$access_token = 'wzwpbz9tZWCSPDrTFYf+APzByZ3jnlV259OV13WiCcsBXMftEVvi/OzVdEy8C31CYj4iA6GdPwQ5QCBnrJPKTNC4IcxZlr4bJwIVRAPd1FlWnDG8ThGjHWY4ZIOD1V/DhshZVuUJUv+YfDrLgh6xtgdB04t89/1O/w1cDnyilFU=';
// Get POST body content
//$content = file_get_contents('php://input');
$content = {"events":[{"type":"message","replyToken":"9a0353fad2ca47009bd42d4716116bb8","source":{"userId":"Ubb0233685f6c43ad7af9f72476d67f16","type":"user"},"timestamp":1484190639335,"message":{"type":"text","id":"5489547671801","text":"p"}}]};
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'template',
				'altText' => 'this is a buttons template',
				'template' => [
					'type' => 'buttons',
					'thumbnailImageUrl' => 'https://upload.wikimedia.org/wikipedia/en/6/6d/Pullinger-150x150.jpg',
					'title' => 'Menu',
					'text' => 'Please select',
					'actions' => [
							'type' => 'postback',
							'label' => 'Buy',
							'data' => 'action=buy&itemid=123'
					]
				]
			];
			
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . '\r\n';
		}
	}
}
echo 'OK';
echo $events;