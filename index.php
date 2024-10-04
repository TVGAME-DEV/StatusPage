<?php
function checkService($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $httpCode == 200;
}

$config = json_decode(file_get_contents('config.json'), true);

$services = $config['services'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="status-page">
        <h1>Service Status</h1>
        <div class="services">
            <?php foreach ($services as $serviceName => $serviceUrl): ?>
                <?php $status = checkService($serviceUrl); ?>
                <div class="service">
                    <span class="service-name"><?php echo $serviceName; ?></span>
                    <span class="service-status <?php echo $status ? 'online' : 'offline'; ?>">
                       <?php echo $status ? 'Online 🟢' : 'Offline 🔴'; ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
