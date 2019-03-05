<?php 
// SMTP class for email sent with saving in outbox
// v 1.0.4
// error_reporting( E_ERROR ); 
class SMTP {
	protected $config;
	protected $headers;
	protected $mail_text;
	protected $letter;
    protected $imap_config;

	public function __construct($host='ssl://smtp.yandex.ru', $port=465, $mail_from_mailbox, $pass, $mail_from_name='',$imap_host='imap.yandex.ru',$imap_port=993, $charset='utf-8')
	{
        $this->config['mail_from_name'] = $mail_from_name; // имя отправителя, например Вася пупкин
        $this->config['mail_from_mailbox'] = $mail_from_mailbox; // емейл (логин) отправителя
		$this->config['smtp_password'] = $pass; //Измените пароль
		$this->config['smtp_port'] = $port; // Порт работы. Не меняйте, если не уверены.
		$this->config['smtp_host'] = $host; //сервер для отправки почты, н
		$this->config['type'] = 'text/html';
		$this->config['charset'] = $charset; //кодировка сообщений. (или UTF-8, итд)
		$this->imap_config['host'] = $imap_host;
		$this->imap_config['port'] = $imap_port;
		
	}

	// добавляем вложения (принимает массив файлов)
    public function add_attachments($files) {
		$this->config['boundary']='';
        for ($i=0; $i < (count($files)) ; $i++) {
            // если windows то конвертируем из 1251 в utf
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $fp = @fopen(iconv('utf-8','windows-1251',$files[$i]), "rb");
            } else {
                $fp = @fopen($files[$i], "rb");//для линукс, мак и прочих использующих utf-8 
            }

            if(!$fp){
                return 'Невозможно открыть файл вложения, проверьте расположение файла/права на доступ к файлу: ' . $files[$i];
            }
            $code_file = @fread($fp, filesize($files[$i]));
            $code_file = chunk_split(base64_encode($code_file));
            fclose($fp);
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $new_name=iconv('windows-1251','utf-8',basename($files[$i]));
            } else {
                $new_name=basename($files[$i]);//для линукс, мак и прочих использующих utf-8 
            }
            
			
            $this->config['boundary'] .= "\r\n".'------------A4D921C2D10D7DB'."\r\n";
            $this->config['boundary'] .= 'Content-Type: application/octet-stream;name="'.$new_name.'"'."\r\n";
            $this->config['boundary'] .= 'Content-transfer-encoding: base64'."\r\n";
            $this->config['boundary'] .= 'Content-Disposition: attachment;filename="' . $new_name . '"'."\r\n\r\n". $code_file .'';
        }
            $this->config['boundary']  = $this->config['boundary']."\r\n".'------------A4D921C2D10D7DB--'."\r\n";
			return true;
    }

	public function get_headers() {
    	$headers  = "Date: ".date("D, d M Y H:i:s",(time()-(3*60*60))) . " UT\r\n";
    	$headers .= "From: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($this->config['mail_from_name'])))."?= " . '<' . ($this->config['mail_from_mailbox']) . '>' . "\r\n";
    	$headers .= "X-Mailer: The Bat! (v3.99.3) Professional\r\n";
    	$headers .= "Reply-To: ".($this->config['mail_from_mailbox'])."\r\n";
    	$headers .= "X-Priority: 3\r\n";
        $headers  .="Message-ID: <172562218." . date("YmjHis") . "@mail.ru>\r\n";
    	$headers .= "To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($this->config['mail_to_name'])))."?= " . '<' . ($this->config['mail_to_mailbox']) . '>' . "\r\n";
        $this->config['subject'] = 'Subject: =?'.($this->config['charset']).'?B?'.base64_encode($this->config['mail_subject'])."=?=\r\n";
        $headers .= ($this->config['subject']);
        
        $headers .= "MIME-Version: 1.0\r\n";
        
        if(($this->config['type'])=='multipart/mixed'){
            $headers.="Content-Type: multipart/mixed; boundary=\"----------A4D921C2D10D7DB\"\r\n\r\n";
        }
        else{
            $headers .= "Content-Transfer-Encoding: 8bit\r\n";
            $headers .= "Content-Type: ". ($this->config['type'])."; charset=\"".($this->config['charset'])."\"\r\n";
        }
        
        $this->headers=$headers;
        return $headers;
	}

	public function letter_construct($attachments) {
        $headers=$this->get_headers();
        $add_attachments = $this->add_attachments($attachments);
		//if($add_attachments !== true) {
		//	return $add_attachments;
		//}
        $mail_text=$this->config['mail_text'];
        if(($this->config['type'])=='multipart/mixed'){
            $text="------------A4D921C2D10D7DB
            Content-Transfer-Encoding: 8 bit"."\r\n".
            "Content-Type: text/html; charset=utf-8"."\r\n";
            $mail_text=$text."\r\n".($this->config['mail_text']);
            $attachments=$this->config['boundary'];
            $this->letter=$headers.$mail_text.$attachments."\r\n\r\n";  
        }
        else{
         $this->letter=$headers.$mail_text."\r\n\r\n";
        }
        return true;
	}

	public function send_mail($mail_to_mailbox,$mail_subject,$mail_text='пустое сообщение',$attachments=array(),$mail_to_name='', $save_in_outbox=true) {
        if(!empty($attachments)){
            $this->config['type']='multipart/mixed';
        }
        $this->config['mail_to_name'] = $mail_to_name;
        $this->config['mail_to_mailbox'] = $mail_to_mailbox;
        $this->config['mail_subject']=$mail_subject;
        $this->config['mail_text']=$mail_text;

        $letter=$this->letter_construct($attachments);
        if($letter!==true){
        	return $letter;
        	die();
        }
        $letter=$this->letter;

        if( !$socket = @fsockopen(($this->config['smtp_host']), ($this->config['smtp_port']), $errno, $errstr, 30) ) {
            return 'Невозможно соединиться с сервером электронной почты, проверьте настройки/соединение с интернетом';
            die();
        }
		$result = $this->server_parse($socket, "220", __LINE__);
		
        if ($result !== true) return $result;

        fputs($socket, "EHLO test" . "\r\n");
        if (!($this->server_parse($socket, "250", __LINE__))) {
			fclose($socket);
			return 'Не могу отправить HELO!';
        }
        fputs($socket, "AUTH LOGIN\r\n");
        if (!($this->server_parse($socket, "334", __LINE__))) {
			fclose($socket);
			return  'Не могу найти ответ на запрос авторизации.';;
        }
        fputs($socket, base64_encode(($this->config['mail_from_mailbox'])) . "\r\n");

        if (!($this->server_parse($socket, "334", __LINE__))) {
            fclose($socket);
			return  'Логин авторизации не был принят сервером! Проверьте настройки.';
            die();
        }
        fputs($socket, base64_encode(($this->config['smtp_password'])) . "\r\n");

        if (!($this->server_parse($socket, "235", __LINE__))) {
            
            fclose($socket);
			return  'Неверный пароль. Ошибка авторизации!';
            die();
        }
        fputs($socket, "MAIL FROM: <".($this->config['mail_from_mailbox']).">\r\n");
        if (!($this->server_parse($socket, "250", __LINE__))) {
            fclose($socket);
            return 'Не могу отправить комманду MAIL FROM';
        }
        fputs($socket, "RCPT TO: <" . ($this->config['mail_to_mailbox']) . ">\r\n");

        if (!($this->server_parse($socket, "250", __LINE__))) {
            fclose($socket);
            return 'Не могу отправить комманду RCPT TO ';
        }
        fputs($socket, "DATA\r\n");

        if (!($this->server_parse($socket, "354", __LINE__))) {
            fclose($socket);
            return 'Не могу отправить комманду DATA';
			exit();

        }
        fputs($socket, ($letter ."\r\n.\r\n"));

        if (!($this->server_parse($socket, "250", __LINE__))) {
				fclose($socket);
				return 'Не смог отправить тело письма. Письмо не было отправлено!';
				exit();
        }
        fputs($socket, "QUIT\r\n");
        fclose($socket);
		if($save_in_outbox) {
			$return_save= $this->save_to_outbox();
			if($return_save!==true) {
				return $return_save;	
			}
		}
        return TRUE;
    }

    public function server_parse($socket, $response, $line = __LINE__) //разбираем ответ сервера
    {
        $server_response='1';
        while (substr($server_response, 3, 1) != ' ') {
            if (!($server_response = fgets($socket, 256))) {
                
                return 'Ошибка: ответ сервера ' . $server_response;
            }
        }
        if (!(substr($server_response, 0, 3) == $response)){
            
            return 'Ошибка: ответ сервера ' . $server_response;
        }
        return true;
    }

    public function save_to_outbox() {
        $mbox = @imap_open( "{" . ($this->imap_config['host']).":" . ($this->imap_config['port']) . "/imap/ssl}", ($this->config['mail_from_mailbox']), ($this->config['smtp_password']) );
		if(!$mbox){
			return 'Невозможно сохранить письмо в исходящих, проверьте настройки imap или соединение с интернетом';
			die();
		}
		$check = imap_check($mbox);
		imap_append($mbox, "{" . ($this->imap_config['host']).":" . ($this->imap_config['port']) ."}&BB4EQgQ,BEAEMAQyBDsENQQ9BD0ESwQ1-", ($this->letter), "\\Seen");
		$check = imap_check($mbox);
		imap_close($mbox);
        return true;
    }
}

 ?>