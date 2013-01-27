<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class PHPMailer
{

    public $Priority = 3;
    public $CharSet = "iso-8859-1";
    public $ContentType = "text/plain";
    public $Encoding = "8bit";
    public $ErrorInfo = "";
    public $From = "root@localhost";
    public $FromName = "Root User";
    public $Sender = "";
    public $Subject = "";
    public $Body = "";
    public $AltBody = "";
    public $WordWrap = 0;
    public $Mailer = "mail";
    public $Sendmail = "/usr/sbin/sendmail";
    public $PluginDir = "";
    public $Version = "2.3";
    public $ConfirmReadingTo = "";
    public $Hostname = "";
    public $MessageID = "";
    public $Host = "localhost";
    public $Port = 25;
    public $Helo = "";
    public $SMTPSecure = "";
    public $SMTPAuth = false;
    public $Username = "";
    public $Password = "";
    public $Timeout = 10;
    public $SMTPDebug = false;
    public $SMTPKeepAlive = false;
    public $SingleTo = false;
    public $LE = "\r\n";
    private $smtp = NULL;
    private $to = array( );
    private $cc = array( );
    private $bcc = array( );
    private $ReplyTo = array( );
    private $attachment = array( );
    private $CustomHeader = array( );
    private $message_type = "";
    private $boundary = array( );
    private $language = array( );
    private $error_count = 0;
    private $sign_cert_file = "";
    private $sign_key_file = "";
    private $sign_key_pass = "";

    public function IsHTML( $bool )
    {
        if ( $bool == true )
        {
            $this->ContentType = "text/html";
        }
        else
        {
            $this->ContentType = "text/plain";
        }
    }

    public function IsSMTP( )
    {
        $this->Mailer = "smtp";
    }

    public function IsMail( )
    {
        $this->Mailer = "mail";
    }

    public function IsSendmail( )
    {
        $this->Mailer = "sendmail";
    }

    public function IsQmail( )
    {
        $this->Sendmail = "/var/qmail/bin/sendmail";
        $this->Mailer = "sendmail";
    }

    public function AddAddress( $address, $name = "" )
    {
        $cur = ( $this->to );
        $this->to[$cur][0] = ( $address );
        $this->to[$cur][1] = $name;
    }

    public function AddCC( $address, $name = "" )
    {
        $cur = ( $this->cc );
        $this->cc[$cur][0] = ( $address );
        $this->cc[$cur][1] = $name;
    }

    public function AddBCC( $address, $name = "" )
    {
        $cur = ( $this->bcc );
        $this->bcc[$cur][0] = ( $address );
        $this->bcc[$cur][1] = $name;
    }

    public function AddReplyTo( $address, $name = "" )
    {
        $cur = ( $this->ReplyTo );
        $this->ReplyTo[$cur][0] = ( $address );
        $this->ReplyTo[$cur][1] = $name;
    }

    public function Send( )
    {
        $header = "";
        $body = "";
        $result = true;
        if ( ( $this->to ) + ( $this->cc ) + ( $this->bcc ) < 1 )
        {
            $this->SetError( $this->Lang( "provide_address" ) );
            return false;
        }
        if ( !empty( $this->AltBody ) )
        {
            $this->ContentType = "multipart/alternative";
        }
        $this->error_count = 0;
        $this->SetMessageType( );
        $header .= $this->CreateHeader( );
        $body = $this->CreateBody( );
        if ( $body == "" )
        {
            return false;
        }
        switch ( $this->Mailer )
        {
        case "sendmail" :
            $result = $this->SendmailSend( $header, $body );
            break;
        case "smtp" :
            $result = $this->SmtpSend( $header, $body );
            break;
        case "mail" :
        }
        $result = $this->MailSend( $header, $body );
        break;
        $result = $this->MailSend( $header, $body );
        break;
        return $result;
    }

    public function SendmailSend( $header, $body )
    {
        if ( $this->Sender != "" )
        {
            $sendmail = ( "%s -oi -f %s -t", ( $this->Sendmail ), ( $this->Sender ) );
        }
        else
        {
            $sendmail = ( "%s -oi -t", ( $this->Sendmail ) );
        }
        if ( !( $mail = @( $sendmail, "w" ) ) )
        {
            $this->SetError( $this->Lang( "execute" ).$this->Sendmail );
            return false;
        }
        ( $mail, $header );
        ( $mail, $body );
        $result = ( $mail );
        if ( ( ( ), "4.2.3" ) == 0 - 1 )
        {
            $result = $result >> 8 & 255;
        }
        if ( $result != 0 )
        {
            $this->SetError( $this->Lang( "execute" ).$this->Sendmail );
            return false;
        }
        return true;
    }

    public function MailSend( $header, $body )
    {
        $to = "";
        $i = 0;
        while ( $i < ( $this->to ) )
        {
            if ( $i != 0 )
            {
                $to .= ", ";
            }
            $to .= $this->AddrFormat( $this->to[$i] );
            ++$i;
        }
        $toArr = ( ",", $to );
        $params = ( "-oi -f %s", $this->Sender );
        if ( $this->Sender != "" && ( ( "safe_mode" ) ) < 1 )
        {
            $old_from = ( "sendmail_from" );
            ( "sendmail_from", $this->Sender );
            if ( $this->SingleTo === true && 1 < ( $toArr ) )
            {
                foreach ( $toArr as $key => $val )
                {
                    $rt = @( $val, @$this->EncodeHeader( @$this->SecureHeader( $this->Subject ) ), $body, $header, $params );
                }
            }
            else
            {
                $rt = @( $to, @$this->EncodeHeader( @$this->SecureHeader( $this->Subject ) ), $body, $header, $params );
            }
        }
        else if ( $this->SingleTo === true && 1 < ( $toArr ) )
        {
            foreach ( $toArr as $key => $val )
            {
                $rt = @( $val, @$this->EncodeHeader( @$this->SecureHeader( $this->Subject ) ), $body, $header, $params );
            }
        }
        else
        {
            $rt = @( $to, @$this->EncodeHeader( @$this->SecureHeader( $this->Subject ) ), $body, $header );
        }
        if ( isset( $old_from ) )
        {
            ( "sendmail_from", $old_from );
        }
        if ( !$rt )
        {
            $this->SetError( $this->Lang( "instantiate" ) );
            return false;
        }
        return true;
    }

    public function SmtpSend( $header, $body )
    {
        include_once( $this->PluginDir."class.smtp.php" );
        $error = "";
        $bad_rcpt = array( );
        if ( !$this->SmtpConnect( ) )
        {
            return false;
        }
        $smtp_from = $this->Sender == "" ? $this->From : $this->Sender;
        if ( !$this->smtp->Mail( $smtp_from ) )
        {
            $error = $this->Lang( "from_failed" ).$smtp_from;
            $this->SetError( $error );
            $this->smtp->Reset( );
            return false;
        }
        $i = 0;
        while ( $i < ( $this->to ) )
        {
            if ( !$this->smtp->Recipient( $this->to[$i][0] ) )
            {
                $bad_rcpt[] = $this->to[$i][0];
            }
            ++$i;
        }
        $i = 0;
        while ( $i < ( $this->cc ) )
        {
            if ( !$this->smtp->Recipient( $this->cc[$i][0] ) )
            {
                $bad_rcpt[] = $this->cc[$i][0];
            }
            ++$i;
        }
        $i = 0;
        while ( $i < ( $this->bcc ) )
        {
            if ( !$this->smtp->Recipient( $this->bcc[$i][0] ) )
            {
                $bad_rcpt[] = $this->bcc[$i][0];
            }
            ++$i;
        }
        if ( 0 < ( $bad_rcpt ) )
        {
            $i = 0;
            while ( $i < ( $bad_rcpt ) )
            {
                if ( $i != 0 )
                {
                    $error .= ", ";
                }
                $error .= $bad_rcpt[$i];
                ++$i;
            }
            $error = $this->Lang( "recipients_failed" ).$error;
            $this->SetError( $error );
            $this->smtp->Reset( );
            return false;
        }
        if ( !$this->smtp->Data( $header.$body ) )
        {
            $this->SetError( $this->Lang( "data_not_accepted" ) );
            $this->smtp->Reset( );
            return false;
        }
        if ( $this->SMTPKeepAlive == true )
        {
            $this->smtp->Reset( );
        }
        else
        {
            $this->SmtpClose( );
        }
        return true;
    }

    public function SmtpConnect( )
    {
        if ( $this->smtp == NULL )
        {
            $this->smtp = new SMTP( );
        }
        $this->smtp->do_debug = $this->SMTPDebug;
        $hosts = ( ";", $this->Host );
        $index = 0;
        $connection = $this->smtp->Connected( );
        while ( $index < ( $hosts ) && $connection == false )
        {
            $hostinfo = array( );
            if ( ( "^(.+):([0-9]+)\$", $hosts[$index], $hostinfo ) )
            {
                $host = $hostinfo[1];
                $port = $hostinfo[2];
            }
            else
            {
                $host = $hosts[$index];
                $port = $this->Port;
            }
            $tls = $this->SMTPSecure == "tls";
            $ssl = $this->SMTPSecure == "ssl";
            if ( $this->smtp->Connect( ( $ssl ? "ssl://" : "" ).$host, $port, $this->Timeout ) )
            {
                $hello = $this->Helo != "" ? $this->Helo : $this->ServerHostname( );
                $this->smtp->Hello( $hello );
                if ( $tls )
                {
                    if ( !$this->smtp->StartTLS( ) )
                    {
                        $this->SetError( $this->Lang( "tls" ) );
                        $this->smtp->Reset( );
                        $connection = false;
                    }
                    $this->smtp->Hello( $hello );
                }
                $connection = true;
                if ( $this->SMTPAuth && !$this->smtp->Authenticate( $this->Username, $this->Password ) )
                {
                    $this->SetError( $this->Lang( "authenticate" ) );
                    $this->smtp->Reset( );
                    $connection = false;
                }
            }
            ++$index;
        }
        if ( !$connection )
        {
            $this->SetError( $this->Lang( "connect_host" ) );
        }
        return $connection;
    }

    public function SmtpClose( )
    {
        if ( $this->smtp != NULL && $this->smtp->Connected( ) )
        {
            $this->smtp->Quit( );
            $this->smtp->Close( );
        }
    }

    public function SetLanguage( $lang_type = "en", $lang_path = "language/" )
    {
        if ( !include( $lang_path."phpmailer.lang-".$lang_type.".php" ) )
        {
            $PHPMAILER_LANG = array( );
            $PHPMAILER_LANG['provide_address'] = "You must provide at least one ".$PHPMAILER_LANG['mailer_not_supported'] = " mailer is not supported.";
            $PHPMAILER_LANG['execute'] = "Could not execute: ";
            $PHPMAILER_LANG['instantiate'] = "Could not instantiate mail function.";
            $PHPMAILER_LANG['authenticate'] = "SMTP Error: Could not authenticate.";
            $PHPMAILER_LANG['from_failed'] = "The following From address failed: ";
            $PHPMAILER_LANG['recipients_failed'] = "SMTP Error: The following ".$PHPMAILER_LANG['data_not_accepted'] = "SMTP Error: Data not accepted.";
            $PHPMAILER_LANG['connect_host'] = "SMTP Error: Could not connect to SMTP host.";
            $PHPMAILER_LANG['file_access'] = "Could not access file: ";
            $PHPMAILER_LANG['file_open'] = "File Error: Could not open file: ";
            $PHPMAILER_LANG['encoding'] = "Unknown encoding: ";
            $PHPMAILER_LANG['signing'] = "Signing Error: ";
        }
        $this->language = $PHPMAILER_LANG;
        return true;
    }

    public function AddrAppend( $type, $addr )
    {
        $addr_str = $type.": ";
        $addr_str .= $this->AddrFormat( $addr[0] );
        if ( 1 < ( $addr ) )
        {
            $i = 1;
            while ( $i < ( $addr ) )
            {
                $addr_str .= ", ".$this->AddrFormat( $addr[$i] );
                ++$i;
            }
        }
        $addr_str .= $this->LE;
        return $addr_str;
    }

    public function AddrFormat( $addr )
    {
        if ( empty( $addr[1] ) )
        {
            $formatted = $this->SecureHeader( $addr[0] );
        }
        else
        {
            $formatted = $this->EncodeHeader( $this->SecureHeader( $addr[1] ), "phrase" )." <".$this->SecureHeader( $addr[0] ).">";
        }
        return $formatted;
    }

    public function WrapText( $message, $length, $qp_mode = false )
    {
        $soft_break = $qp_mode ? ( " =%s", $this->LE ) : $this->LE;
        $is_utf8 = ( $this->CharSet ) == "utf-8";
        $message = $this->FixEOL( $message );
        if ( ( $message, 0 - 1 ) == $this->LE )
        {
            $message = ( $message, 0, 0 - 1 );
        }
        $line = ( $this->LE, $message );
        $message = "";
        $i = 0;
        while ( $i < ( $line ) )
        {
            $line_part = ( " ", $line[$i] );
            $buf = "";
            $e = 0;
            while ( $e < ( $line_part ) )
            {
                $word = $line_part[$e];
                if ( $qp_mode && $length < ( $word ) )
                {
                    $space_left = $length - ( $buf ) - 1;
                    if ( $e != 0 )
                    {
                        if ( 20 < $space_left )
                        {
                            $len = $space_left;
                            if ( $is_utf8 )
                            {
                                $len = $this->UTF8CharBoundary( $word, $len );
                            }
                            else if ( ( $word, $len - 1, 1 ) == "=" )
                            {
                                --$len;
                            }
                            else if ( ( $word, $len - 2, 1 ) == "=" )
                            {
                                $len -= 2;
                            }
                            $part = ( $word, 0, $len );
                            $word = ( $word, $len );
                            $buf .= " ".$part;
                            $message .= $buf.( "=%s", $this->LE );
                        }
                        else
                        {
                            $message .= $buf.$soft_break;
                        }
                        $buf = "";
                    }
                    while ( 0 < ( $word ) )
                    {
                        $len = $length;
                        if ( $is_utf8 )
                        {
                            $len = $this->UTF8CharBoundary( $word, $len );
                        }
                        else if ( ( $word, $len - 1, 1 ) == "=" )
                        {
                            --$len;
                        }
                        else if ( ( $word, $len - 2, 1 ) == "=" )
                        {
                            $len -= 2;
                        }
                        $part = ( $word, 0, $len );
                        $word = ( $word, $len );
                        if ( 0 < ( $word ) )
                        {
                            $message .= $part.( "=%s", $this->LE );
                        }
                        else
                        {
                            $buf = $part;
                        }
                    }
                }
                else
                {
                    $buf_o = $buf;
                    $buf .= $e == 0 ? $word : " ".$word;
                    if ( $length < ( $buf ) && $buf_o != "" )
                    {
                        $message .= $buf_o.$soft_break;
                        $buf = $word;
                    }
                }
                ++$e;
            }
            $message .= $buf.$this->LE;
            ++$i;
        }
        return $message;
    }

    public function UTF8CharBoundary( $encodedText, $maxLength )
    {
        $foundSplitPos = false;
        $lookBack = 3;
        while ( !$foundSplitPos )
        {
            $lastChunk = ( $encodedText, $maxLength - $lookBack, $lookBack );
            $encodedCharPos = ( $lastChunk, "=" );
            if ( $encodedCharPos !== false )
            {
                $hex = ( $encodedText, $maxLength - $lookBack + $encodedCharPos + 1, 2 );
                $dec = ( $hex );
                if ( $dec < 128 )
                {
                    $maxLength = $maxLength - ( $lookBack - $encodedCharPos );
                    $foundSplitPos = true;
                }
                else if ( 192 <= $dec )
                {
                    $maxLength = $maxLength - ( $lookBack - $encodedCharPos );
                    $foundSplitPos = true;
                }
                else if ( $dec < 192 )
                {
                    $lookBack += 3;
                }
            }
            else
            {
                $foundSplitPos = true;
            }
        }
        return $maxLength;
    }

    public function SetWordWrap( )
    {
        if ( $this->WordWrap < 1 )
        {
            return;
        }
        switch ( $this->message_type )
        {
        case "alt" :
            break;
        case "alt_attachments" :
        }
        $this->AltBody = $this->WrapText( $this->AltBody, $this->WordWrap );
        break;
        $this->Body = $this->WrapText( $this->Body, $this->WordWrap );
        break;
    }

    public function CreateHeader( )
    {
        $result = "";
        $uniq_id = ( ( ( ) ) );
        $this->boundary[1] = "b1_".$uniq_id;
        $this->boundary[2] = "b2_".$uniq_id;
        $result .= $this->HeaderLine( "Date", $this->RFCDate( ) );
        if ( $this->Sender == "" )
        {
            $result .= $this->HeaderLine( "Return-Path", ( $this->From ) );
        }
        else
        {
            $result .= $this->HeaderLine( "Return-Path", ( $this->Sender ) );
        }
        if ( $this->Mailer != "mail" )
        {
            if ( 0 < ( $this->to ) )
            {
                $result .= $this->AddrAppend( "To", $this->to );
            }
            else if ( ( $this->cc ) == 0 )
            {
                $result .= $this->HeaderLine( "To", "undisclosed-recipients:;" );
            }
        }
        $from = array( );
        $from[0][0] = ( $this->From );
        $from[0][1] = $this->FromName;
        $result .= $this->AddrAppend( "From", $from );
        if ( ( $this->Mailer == "sendmail" || $this->Mailer == "mail" ) && 0 < ( $this->cc ) )
        {
            $result .= $this->AddrAppend( "Cc", $this->cc );
        }
        if ( ( $this->Mailer == "sendmail" || $this->Mailer == "mail" ) && 0 < ( $this->bcc ) )
        {
            $result .= $this->AddrAppend( "Bcc", $this->bcc );
        }
        if ( 0 < ( $this->ReplyTo ) )
        {
            $result .= $this->AddrAppend( "Reply-to", $this->ReplyTo );
        }
        if ( $this->Mailer != "mail" )
        {
            $result .= $this->HeaderLine( "Subject", $this->EncodeHeader( $this->SecureHeader( $this->Subject ) ) );
        }
        if ( $this->MessageID != "" )
        {
            $result .= $this->HeaderLine( "Message-ID", $this->MessageID );
        }
        else
        {
            $result .= ( "Message-ID: <%s@%s>%s", $uniq_id, $this->ServerHostname( ), $this->LE );
        }
        $result .= $this->HeaderLine( "X-Priority", $this->Priority );
        $result .= $this->HeaderLine( "X-Mailer", "PHPMailer (phpmailer.codeworxtech.com) [version ".$this->Version."]" );
        if ( $this->ConfirmReadingTo != "" )
        {
            $result .= $this->HeaderLine( "Disposition-Notification-To", "<".( $this->ConfirmReadingTo ).">" );
        }
        $index = 0;
        while ( $index < ( $this->CustomHeader ) )
        {
            $result .= $this->HeaderLine( ( $this->CustomHeader[$index][0] ), $this->EncodeHeader( ( $this->CustomHeader[$index][1] ) ) );
            ++$index;
        }
        if ( !$this->sign_key_file )
        {
            $result .= $this->HeaderLine( "MIME-Version", "1.0" );
            $result .= $this->GetMailMIME( );
        }
        return $result;
    }

    public function GetMailMIME( )
    {
        $result = "";
        switch ( $this->message_type )
        {
        case "plain" :
            $result .= $this->HeaderLine( "Content-Transfer-Encoding", $this->Encoding );
            $result .= ( "Content-Type: %s; charset=\"%s\"", $this->ContentType, $this->CharSet );
            break;
        case "attachments" :
        case "alt_attachments" :
            if ( $this->InlineImageExists( ) )
            {
                $result .= ( "Content-Type: %s;%s\ttype=\"text/html\";%s\tboundary=\"%s\"%s", "multipart/related", $this->LE, $this->LE, $this->boundary[1], $this->LE );
            }
            $result .= $this->HeaderLine( "Content-Type", "multipart/mixed;" );
            $result .= $this->TextLine( "\tboundary=\"".$this->boundary[1]."\"" );
            break;
        case "alt" :
            $result .= $this->HeaderLine( "Content-Type", "multipart/alternative;" );
            $result .= $this->TextLine( "\tboundary=\"".$this->boundary[1]."\"" );
        }
        if ( $this->Mailer != "mail" )
        {
            $result .= $this->LE.$this->LE;
        }
        return $result;
    }

    public function CreateBody( )
    {
        $result = "";
        if ( $this->sign_key_file )
        {
            $result .= $this->GetMailMIME( );
        }
        $this->SetWordWrap( );
        switch ( $this->message_type )
        {
        case "alt" :
            $result .= $this->GetBoundary( $this->boundary[1], "", "text/plain", "" );
            $result .= $this->EncodeString( $this->AltBody, $this->Encoding );
            $result .= $this->LE.$this->LE;
            $result .= $this->GetBoundary( $this->boundary[1], "", "text/html", "" );
            $result .= $this->EncodeString( $this->Body, $this->Encoding );
            $result .= $this->LE.$this->LE;
            $result .= $this->EndBoundary( $this->boundary[1] );
            break;
        case "plain" :
            $result .= $this->EncodeString( $this->Body, $this->Encoding );
            break;
        case "attachments" :
            $result .= $this->GetBoundary( $this->boundary[1], "", "", "" );
            $result .= $this->EncodeString( $this->Body, $this->Encoding );
            $result .= $this->LE;
            $result .= $this->AttachAll( );
            break;
        case "alt_attachments" :
            $result .= ( "--%s%s", $this->boundary[1], $this->LE );
            $result .= ( "Content-Type: %s;%s"."\tboundary=\"%s\"%s", "multipart/alternative", $this->LE, $this->boundary[2], $this->LE.$this->LE );
            $result .= $this->GetBoundary( $this->boundary[2], "", "text/plain", "" ).$this->LE;
            $result .= $this->EncodeString( $this->AltBody, $this->Encoding );
            $result .= $this->LE.$this->LE;
            $result .= $this->GetBoundary( $this->boundary[2], "", "text/html", "" ).$this->LE;
            $result .= $this->EncodeString( $this->Body, $this->Encoding );
            $result .= $this->LE.$this->LE;
            $result .= $this->EndBoundary( $this->boundary[2] );
            $result .= $this->AttachAll( );
        }
        if ( $this->IsError( ) )
        {
            $result = "";
        }
        else if ( $this->sign_key_file )
        {
            $file = ( "", "mail" );
            $fp = ( $file, "w" );
            ( $fp, $result );
            ( $fp );
            $signed = ( "", "signed" );
            if ( @( $file, $signed, "file://".$this->sign_cert_file, array(
                "file://".$this->sign_key_file,
                $this->sign_key_pass
            ), null ) )
            {
                $fp = ( $signed, "r" );
                $result = "";
                while ( !( $fp ) )
                {
                    $result = $result.( $fp, 1024 );
                }
                ( $fp );
            }
            else
            {
                $this->SetError( $this->Lang( "signing" ).( ) );
                $result = "";
            }
            ( $file );
            ( $signed );
        }
        return $result;
    }

    public function GetBoundary( $boundary, $charSet, $contentType, $encoding )
    {
        $result = "";
        if ( $charSet == "" )
        {
            $charSet = $this->CharSet;
        }
        if ( $contentType == "" )
        {
            $contentType = $this->ContentType;
        }
        if ( $encoding == "" )
        {
            $encoding = $this->Encoding;
        }
        $result .= $this->TextLine( "--".$boundary );
        $result .= ( "Content-Type: %s; charset = \"%s\"", $contentType, $charSet );
        $result .= $this->LE;
        $result .= $this->HeaderLine( "Content-Transfer-Encoding", $encoding );
        $result .= $this->LE;
        return $result;
    }

    public function EndBoundary( $boundary )
    {
        return $this->LE."--".$boundary."--".$this->LE;
    }

    public function SetMessageType( )
    {
        if ( ( $this->attachment ) < 1 && ( $this->AltBody ) < 1 )
        {
            $this->message_type = "plain";
        }
        else
        {
            if ( 0 < ( $this->attachment ) )
            {
                $this->message_type = "attachments";
            }
            if ( 0 < ( $this->AltBody ) && ( $this->attachment ) < 1 )
            {
                $this->message_type = "alt";
            }
            if ( 0 < ( $this->AltBody ) && 0 < ( $this->attachment ) )
            {
                $this->message_type = "alt_attachments";
            }
        }
    }

    public function HeaderLine( $name, $value )
    {
        return $name.": ".$value.$this->LE;
    }

    public function TextLine( $value )
    {
        return $value.$this->LE;
    }

    public function AddAttachment( $path, $name = "", $encoding = "base64", $type = "application/octet-stream" )
    {
        if ( !( $path ) )
        {
            $this->SetError( $this->Lang( "file_access" ).$path );
            return false;
        }
        $filename = ( $path );
        if ( $name == "" )
        {
            $name = $filename;
        }
        $cur = ( $this->attachment );
        $this->attachment[$cur][0] = $path;
        $this->attachment[$cur][1] = $filename;
        $this->attachment[$cur][2] = $name;
        $this->attachment[$cur][3] = $encoding;
        $this->attachment[$cur][4] = $type;
        $this->attachment[$cur][5] = false;
        $this->attachment[$cur][6] = "attachment";
        $this->attachment[$cur][7] = 0;
        return true;
    }

    public function AttachAll( )
    {
        $mime = array( );
        $i = 0;
        while ( $i < ( $this->attachment ) )
        {
            $bString = $this->attachment[$i][5];
            if ( $bString )
            {
                $string = $this->attachment[$i][0];
            }
            else
            {
                $path = $this->attachment[$i][0];
            }
            $filename = $this->attachment[$i][1];
            $name = $this->attachment[$i][2];
            $encoding = $this->attachment[$i][3];
            $type = $this->attachment[$i][4];
            $disposition = $this->attachment[$i][6];
            $cid = $this->attachment[$i][7];
            $mime[] = ( "--%s%s", $this->boundary[1], $this->LE );
            $mime[] = ( "Content-Type: %s; name=\"%s\"%s", $type, $this->EncodeHeader( $this->SecureHeader( $name ) ), $this->LE );
            $mime[] = ( "Content-Transfer-Encoding: %s%s", $encoding, $this->LE );
            if ( $disposition == "inline" )
            {
                $mime[] = ( "Content-ID: <%s>%s", $cid, $this->LE );
            }
            $mime[] = ( "Content-Disposition: %s; filename=\"%s\"%s", $disposition, $this->EncodeHeader( $this->SecureHeader( $name ) ), $this->LE.$this->LE );
            if ( $bString )
            {
                $mime[] = $this->EncodeString( $string, $encoding );
                if ( $this->IsError( ) )
                {
                    return "";
                }
                $mime[] = $this->LE.$this->LE;
            }
            else
            {
                $mime[] = $this->EncodeFile( $path, $encoding );
                if ( $this->IsError( ) )
                {
                    return "";
                }
                $mime[] = $this->LE.$this->LE;
            }
            ++$i;
        }
        $mime[] = ( "--%s--%s", $this->boundary[1], $this->LE );
        return ( "", $mime );
    }

    public function EncodeFile( $path, $encoding = "base64" )
    {
        if ( !( $fd = @( $path, "rb" ) ) )
        {
            $this->SetError( $this->Lang( "file_open" ).$path );
            return "";
        }
        else
        {
            if ( ( "get_magic_quotes" ) )
            {
            }
            if ( PHP_VERSION < 6 )
            {
                $magic_quotes = ( );
                ( 0 );
            }
            $file_buffer = ( $path );
            $file_buffer = $this->EncodeString( $file_buffer, $encoding );
            ( $fd );
            if ( PHP_VERSION < 6 )
            {
                ( $magic_quotes );
            }
        }
        return $file_buffer;
    }

    public function EncodeString( $str, $encoding = "base64" )
    {
        $encoded = "";
        switch ( ( $encoding ) )
        {
        case "base64" :
            $encoded = ( ( $str ), 76, $this->LE );
            break;
        case "7bit" :
        case "8bit" :
            $encoded = $this->FixEOL( $str );
            if ( ( $encoded, 0 - ( $this->LE ) ) != $this->LE )
            {
                $encoded .= $this->LE;
            }
            break;
        case "binary" :
            $encoded = $str;
            break;
        case "quoted-printable" :
        }
        $encoded = $this->EncodeQP( $str );
        break;
        $this->SetError( $this->Lang( "encoding" ).$encoding );
        break;
        return $encoded;
    }

    public function EncodeHeader( $str, $position = "text" )
    {
        $x = 0;
        switch ( ( $position ) )
        {
        case "phrase" :
            do
            {
                if ( ( "/[\\200-\\377]/", $str ) )
                {
                    break;
                }
                else
                {
                    $encoded = ( $str, "\x00..\x1F\\\"" );
                    if ( $str == $encoded && !( "/[^A-Za-z0-9!#\$%&'*+\\/=?^_`{|}~ -]/", $str ) )
                    {
                        return $encoded;
                    }
                }
                return "\"{$encoded}\"";
            } while ( 0 );
            $x = ( "/[^\\040\\041\\043-\\133\\135-\\176]/", $str, $matches );
            break;
        case "comment" :
            $x = ( "/[()\"]/", $str, $matches );
        case "text" :
        }
        $x += ( "/[\\000-\\010\\013\\014\\016-\\037\\177-\\377]/", $str, $matches );
        break;
        if ( $x == 0 )
        {
            return $str;
        }
        $maxlen = 75 - 7 - ( $this->CharSet );
        if ( ( $str ) / 3 < $x )
        {
            do
            {
                $encoding = "B";
                if ( ( "mb_strlen" ) && $this->HasMultiBytes( $str ) )
                {
                    $encoded = $this->Base64EncodeWrapMB( $str );
                    break;
                }
                else
                {
                    $encoded = ( $str );
                    $maxlen -= $maxlen % 4;
                    $encoded = ( ( $encoded, $maxlen, "\n" ) );
                }
            }
            $encoding = "Q";
            $encoded = $this->EncodeQ( $str, $position );
            $encoded = $this->WrapText( $encoded, $maxlen, true );
            $encoded = ( "=".$this->LE, "\n", ( $encoded ) );
        } while ( 0 );
        $encoded = ( "/^(.*)\$/m", " =?".$this->CharSet."?{$encoding}?\\1?=", $encoded );
        $encoded = ( ( "\n", $this->LE, $encoded ) );
        return $encoded;
    }

    public function HasMultiBytes( $str )
    {
        if ( ( "mb_strlen" ) )
        {
            return ( $str, $this->CharSet ) < ( $str );
        }
        return False;
    }

    public function Base64EncodeWrapMB( $str )
    {
        $start = "=?".$this->CharSet."?B?";
        $end = "?=";
        $encoded = "";
        $mb_length = ( $str, $this->CharSet );
        $length = 75 - ( $start ) - ( $end );
        $ratio = $mb_length / ( $str );
        $offset = $avgLength = ( $length * $ratio * 0.75 );
        $i = 0;
        while ( $i < $mb_length )
        {
            $lookBack = 0;
            do
            {
                $offset = $avgLength - $lookBack;
                $chunk = ( $str, $i, $offset, $this->CharSet );
                $chunk = ( $chunk );
                ++$lookBack;
            } while ( $length < ( $chunk ) );
            $encoded .= $chunk.$this->LE;
            $i += $offset;
        }
        $encoded = ( $encoded, 0, 0 - ( $this->LE ) );
        return $encoded;
    }

    public function EncodeQP( $input = "", $line_max = 76, $space_conv = false )
    {
        $hex = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F" );
        $lines = ( "/(?:\\r\\n|\\r|\\n)/", $input );
        $eol = "\r\n";
        $escape = "=";
        $output = "";
        while ( list( , $line ) = line )
        {
            $linlen = ( $line );
            $newline = "";
            $i = 0;
            while ( $i < $linlen )
            {
                $c = ( $line, $i, 1 );
                $dec = ( $c );
                if ( $i == 0 && $dec == 46 )
                {
                    $c = "=2E";
                }
                if ( $dec == 32 )
                {
                    if ( $i == $linlen - 1 )
                    {
                        $c = "=20";
                    }
                    else if ( $space_conv )
                    {
                        $c = "=20";
                    }
                }
                else if ( $dec == 61 || $dec < 32 || 126 < $dec )
                {
                    $h2 = ( $dec / 16 );
                    $h1 = ( $dec % 16 );
                    $c = $escape.$hex[$h2].$hex[$h1];
                }
                if ( $line_max <= ( $newline ) + ( $c ) )
                {
                    $output .= $newline.$escape.$eol;
                    $newline = "";
                    if ( $dec == 46 )
                    {
                        $c = "=2E";
                    }
                }
                $newline .= $c;
                ++$i;
            }
            $output .= $newline.$eol;
        }
        return $output;
    }

    public function EncodeQ( $str, $position = "text" )
    {
        $encoded = ( "[\r\n]", "", $str );
        switch ( ( $position ) )
        {
        case "phrase" :
            $encoded = ( "/([^A-Za-z0-9!*+\\/ -])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded );
            break;
        case "comment" :
            $encoded = ( "/([\\(\\)\"])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded );
        case "text" :
        }
        $encoded = ( "/([\\000-\\011\\013\\014\\016-\\037\\075\\077\\137\\177-\\377])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded );
        break;
        $encoded = ( " ", "_", $encoded );
        return $encoded;
    }

    public function AddStringAttachment( $string, $filename, $encoding = "base64", $type = "application/octet-stream" )
    {
        $cur = ( $this->attachment );
        $this->attachment[$cur][0] = $string;
        $this->attachment[$cur][1] = $filename;
        $this->attachment[$cur][2] = $filename;
        $this->attachment[$cur][3] = $encoding;
        $this->attachment[$cur][4] = $type;
        $this->attachment[$cur][5] = true;
        $this->attachment[$cur][6] = "attachment";
        $this->attachment[$cur][7] = 0;
    }

    public function AddEmbeddedImage( $path, $cid, $name = "", $encoding = "base64", $type = "application/octet-stream" )
    {
        if ( !( $path ) )
        {
            $this->SetError( $this->Lang( "file_access" ).$path );
            return false;
        }
        $filename = ( $path );
        if ( $name == "" )
        {
            $name = $filename;
        }
        $cur = ( $this->attachment );
        $this->attachment[$cur][0] = $path;
        $this->attachment[$cur][1] = $filename;
        $this->attachment[$cur][2] = $name;
        $this->attachment[$cur][3] = $encoding;
        $this->attachment[$cur][4] = $type;
        $this->attachment[$cur][5] = false;
        $this->attachment[$cur][6] = "inline";
        $this->attachment[$cur][7] = $cid;
        return true;
    }

    public function InlineImageExists( )
    {
        $result = false;
        $i = 0;
        while ( $i < ( $this->attachment ) )
        {
            if ( $this->attachment[$i][6] == "inline" )
            {
                $result = true;
                break;
            }
            ++$i;
        }
        return $result;
    }

    public function ClearAddresses( )
    {
        $this->to = array( );
    }

    public function ClearCCs( )
    {
        $this->cc = array( );
    }

    public function ClearBCCs( )
    {
        $this->bcc = array( );
    }

    public function ClearReplyTos( )
    {
        $this->ReplyTo = array( );
    }

    public function ClearAllRecipients( )
    {
        $this->to = array( );
        $this->cc = array( );
        $this->bcc = array( );
    }

    public function ClearAttachments( )
    {
        $this->attachment = array( );
    }

    public function ClearCustomHeaders( )
    {
        $this->CustomHeader = array( );
    }

    private function SetError( $msg )
    {
        $this->error_count++;
        $this->ErrorInfo = $msg;
    }

    private static function RFCDate( )
    {
        $tz = ( "Z" );
        $tzs = $tz < 0 ? "-" : "+";
        $tz = ( $tz );
        $tz = ( integer )( $tz / 3600 ) * 100 + $tz % 3600 / 60;
        $result = ( "%s %s%04d", ( "D, j M Y H:i:s" ), $tzs, $tz );
        return $result;
    }

    private function ServerHostname( )
    {
        if ( !empty( $this->Hostname ) )
        {
            $result = $this->Hostname;
        }
        else if ( isset( $_SERVER['SERVER_NAME'] ) )
        {
            $result = $_SERVER['SERVER_NAME'];
        }
        else
        {
            $result = "localhost.localdo".__FILE__;
        }
        return $result;
    }

    private function Lang( $key )
    {
        if ( ( $this->language ) < 1 )
        {
            $this->SetLanguage( "en" );
        }
        if ( isset( $this->language[$key] ) )
        {
            return $this->language[$key];
        }
        return "Language string failed to load: ".$key;
    }

    public function IsError( )
    {
        return 0 < $this->error_count;
    }

    private function FixEOL( $str )
    {
        $str = ( "\r\n", "\n", $str );
        $str = ( "\r", "\n", $str );
        $str = ( "\n", $this->LE, $str );
        return $str;
    }

    public function AddCustomHeader( $custom_header )
    {
        $this->CustomHeader[] = ( ":", $custom_header, 2 );
    }

    public function MsgHTML( $message, $basedir = "" )
    {
        ( "/(src|background)=\"(.*)\"/Ui", $message, $images );
        if ( isset( $images[2] ) )
        {
            foreach ( $images[2] as $i => $url )
            {
                if ( !( "/^[A-z][A-z]*:\\/\\//", $url ) )
                {
                    $filename = ( $url );
                    $directory = ( $url );
                    $directory == "." ? ( $directory = "" ) : "";
                    $cid = "cid:".( $filename );
                    $fileParts = ( "\\.", $filename );
                    $ext = $fileParts[1];
                    $mimeType = $this->_mime_types( $ext );
                    if ( 1 < ( $basedir ) && ( $basedir, 0 - 1 ) != "/" )
                    {
                        $basedir .= "/";
                    }
                    if ( 1 < ( $directory ) && ( $directory, 0 - 1 ) != "/" )
                    {
                        $directory .= "/";
                    }
                    if ( $this->AddEmbeddedImage( $basedir.$directory.$filename, ( $filename ), $filename, "base64", $mimeType ) )
                    {
                        $message = ( "/".$images[1][$i]."=\"".( $url, "/" )."\"/Ui", $images[1][$i]."=\"".$cid."\"", $message );
                    }
                }
            }
        }
        $this->IsHTML( true );
        $this->Body = $message;
        $textMsg = ( ( ( "/<(head|title|style|script)[^>]*>.*?<\\/\\1>/s", "", $message ) ) );
        if ( !empty( $textMsg ) && empty( $this->AltBody ) )
        {
            $this->AltBody = ( $textMsg );
        }
        if ( empty( $this->AltBody ) )
        {
            $this->AltBody = "To view this email message, open the email in with HTML compatibility!"."\n\n";
        }
    }

    public function _mime_types( $ext = "" )
    {
        $mimes = array( "hqx" => "application/mac-binhex40", "cpt" => "application/mac-compactpro", "doc" => "application/msword", "bin" => "application/macbinary", "dms" => "application/octet-stream", "lha" => "application/octet-stream", "lzh" => "application/octet-stream", "exe" => "application/octet-stream", "class" => "application/octet-stream", "psd" => "application/octet-stream", "so" => "application/octet-stream", "sea" => "application/octet-stream", "dll" => "application/octet-stream", "oda" => "application/oda", "pdf" => "application/pdf", "ai" => "application/postscript", "eps" => "application/postscript", "ps" => "application/postscript", "smi" => "application/smil", "smil" => "application/smil", "mif" => "application/vnd.mif", "xls" => "application/vnd.ms-excel", "ppt" => "application/vnd.ms-powerpoint", "wbxml" => "application/vnd.wap.wbxml", "wmlc" => "application/vnd.wap.wmlc", "dcr" => "application/x-director", "dir" => "application/x-director", "dxr" => "application/x-director", "dvi" => "application/x-dvi", "gtar" => "application/x-gtar", "php" => "application/x-httpd-php", "php4" => "application/x-httpd-php", "php3" => "application/x-httpd-php", "phtml" => "application/x-httpd-php", "phps" => "application/x-httpd-php-source", "js" => "application/x-javascript", "swf" => "application/x-shockwave-flash", "sit" => "application/x-stuffit", "tar" => "application/x-tar", "tgz" => "application/x-tar", "xhtml" => "application/xhtml+xml", "xht" => "application/xhtml+xml", "zip" => "application/zip", "mid" => "audio/midi", "midi" => "audio/midi", "mpga" => "audio/mpeg", "mp2" => "audio/mpeg", "mp3" => "audio/mpeg", "aif" => "audio/x-aiff", "aiff" => "audio/x-aiff", "aifc" => "audio/x-aiff", "ram" => "audio/x-pn-realaudio", "rm" => "audio/x-pn-realaudio", "rpm" => "audio/x-pn-realaudio-plugin", "ra" => "audio/x-realaudio", "rv" => "video/vnd.rn-realvideo", "wav" => "audio/x-wav", "bmp" => "image/bmp", "gif" => "image/gif", "jpeg" => "image/jpeg", "jpg" => "image/jpeg", "jpe" => "image/jpeg", "png" => "image/png", "tiff" => "image/tiff", "tif" => "image/tiff", "css" => "text/css", "html" => "text/html", "htm" => "text/html", "shtml" => "text/html", "txt" => "text/plain", "text" => "text/plain", "log" => "text/plain", "rtx" => "text/richtext", "rtf" => "text/rtf", "xml" => "text/xml", "xsl" => "text/xml", "mpeg" => "video/mpeg", "mpg" => "video/mpeg", "mpe" => "video/mpeg", "qt" => "video/quicktime", "mov" => "video/quicktime", "avi" => "video/x-msvideo", "movie" => "video/x-sgi-movie", "doc" => "application/msword", "word" => "application/msword", "xl" => "application/excel", "eml" => "message/rfc822" );
        return !isset( $mimes[( $ext )] ) ? "application/octet-stream" : $mimes[( $ext )];
    }

    public function set( $name, $value = "" )
    {
        if ( isset( $this->$name ) )
        {
            $this->$name = $value;
        }
        else
        {
            $this->SetError( "Cannot set or reset variable ".$name );
        }
        return false;
    }

    public function getFile( $filename )
    {
        $return = "";
        if ( $fp = ( $filename, "rb" ) )
        {
            while ( !( $fp ) )
            {
                $return .= ( $fp, 1024 );
            }
            ( $fp );
            return $return;
        }
        return false;
    }

    public function SecureHeader( $str )
    {
        $str = ( $str );
        $str = ( "\r", "", $str );
        $str = ( "\n", "", $str );
        return $str;
    }

    public function Sign( $cert_filename, $key_filename, $key_pass )
    {
        $this->sign_cert_file = $cert_filename;
        $this->sign_key_file = $key_filename;
        $this->sign_key_pass = $key_pass;
    }

}

?>
