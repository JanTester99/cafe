<?php

namespace App\Shopping;

class Mailer {

    public function deliver(string $recipientEmail, string $message):string {

        echo "MAILER LONG DISTANCE CALL \n";
        echo 'Message sent: '.$message ."\n";
        return 'Message sent: '.$message;
    }
}