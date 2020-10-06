<?php

Yii::setAlias('@imagepath', $_SERVER['DOCUMENT_ROOT'].'/uploads/');
Yii::setAlias('@imageurl', '/uploads/');

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
];
